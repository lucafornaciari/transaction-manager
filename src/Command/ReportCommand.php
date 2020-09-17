<?php


namespace App\Command;


use App\Entity\Transaction;
use App\Exception\ExporterNotFoundException;
use App\Repository\TransactionRepository;
use App\Adapter\TransactionAdapter;
use App\Service\CurrencyConverter;
use App\Service\Exporter\ExporterFactory;
use App\Service\Exporter\ExporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportCommand extends Command
{
    protected static $defaultName = 'generate-report';

    protected const CUSTOMER_ID_ARGUMENT = 'customerId';

    /** @var TransactionRepository */
    protected $transactionRepository;

    /** @var CurrencyConverter */
    protected $currencyConverter;

    /** @var ExporterFactory */
    protected $exporterFactory;

    /** @var TransactionAdapter */
    protected $transactionAdapter;

    /**
     * ReportCommand constructor.
     *
     * @param TransactionRepository $transactionRepository
     * @param CurrencyConverter $currencyConverter
     * @param ExporterFactory $exporterFactory
     * @param TransactionAdapter $transactionAdapter
     * @param string|null $name
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        CurrencyConverter $currencyConverter,
        ExporterFactory $exporterFactory,
        TransactionAdapter $transactionAdapter,
        string $name = null)
    {
        parent::__construct($name);

        $this->currencyConverter = $currencyConverter;
        $this->transactionRepository = $transactionRepository;
        $this->exporterFactory = $exporterFactory;
        $this->transactionAdapter = $transactionAdapter;
    }

    protected function configure()
    {
        // available with "php bin/console list"
        $this->setDescription('Creates a new report by Customer Id.');
        $this->addArgument(self::CUSTOMER_ID_ARGUMENT, InputArgument::REQUIRED, 'The customer id');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws ExporterNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customerId = intval($input->getArgument(self::CUSTOMER_ID_ARGUMENT));

        //Retrieve transactions by customer Id
        /** @var Transaction[] $transactions */
        $transactions = $this->transactionRepository->getByCustomerId($customerId);

        //Convert transactions in Euro
        $transactions = array_map(function (Transaction $transaction) {
            return $this->currencyConverter->convert($transaction);
        }, $transactions);

        /** @var ExporterInterface $exporter */
        $exporter = $this->exporterFactory->getExporter(ExporterFactory::CSV_EXPORT);
        $exporter->export($this->transactionAdapter->adapt($transactions), 'customer_' . $customerId . '_transactions');

        $output->writeln('CSV was generated');

        return Command::SUCCESS;
    }
}