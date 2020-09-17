<?php


namespace App\Service\Exporter;


use App\Exception\ExporterNotFoundException;

class ExporterFactory
{
    public const CSV_EXPORT = 'CSV';

    /** @var CsvExporter */
    protected $CsvExporter;

    /**
     * ExporterFactory constructor.
     *
     * @param CsvExporter $CsvExporter
     */
    public function __construct(CsvExporter $CsvExporter)
    {
        $this->CsvExporter = $CsvExporter;
    }


    /**
     * @param $exporter
     * @return ExporterInterface
     *
     * @throws ExporterNotFoundException
     */
    public function getExporter($exporter)
    {
        switch ($exporter) {
            case self::CSV_EXPORT: return $this->CsvExporter;
            default:
                throw new ExporterNotFoundException('Exporter not found');
        }
    }
}