<?php


namespace App\Repository;


use App\Entity\Transaction;
use App\Utility\CSVParser;
use App\Formatter\TransactionFormatter;

class TransactionRepository
{
    /** @var CSVParser */
    protected $csvParser;

    /** @var TransactionFormatter */
    protected $transactionFormatter;

    public function __construct(CSVParser $csvParser, TransactionFormatter $transactionFormatter)
    {
        $this->csvParser = $csvParser;
        $this->transactionFormatter = $transactionFormatter;
    }

    /**
     * In a real project this method will do a direct query with a condition on customerId
     *
     * @param $customerId
     * @return Transaction[]
     */
    public function getByCustomerId($customerId) {
        return array_filter($this->findAll(), function (Transaction $transaction) use ($customerId) {
            return $transaction->getCustomer() === $customerId;
        });
    }

    /**
     * This method simulate the DB query. We import data from csv file and trasform results in a Transactions array.
     *
     * @return Transaction[]
     */
    public function findAll() {
        $transactions = $this->csvParser->parse('data.csv');

        return array_map(function ($record) {
            return $this->transactionFormatter->format($record);
        }, $transactions);
    }
}