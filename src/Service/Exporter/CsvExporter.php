<?php


namespace App\Service\Exporter;


class CsvExporter implements ExporterInterface
{
    /**
     * @param array $data
     * @param string $filename
     */
    public function export(array $data, string $filename)
    {
        //Header row by array keys
        array_unshift($data, array_keys(reset($data)));

        $filename = $filename . '_' . date('Ymd') . '.csv';
        $fp = fopen($filename, "w");

        foreach ($data as $line) {
            fputcsv(
                $fp,
                $line,
                ','
            );
        }

        fclose($fp);
    }
}