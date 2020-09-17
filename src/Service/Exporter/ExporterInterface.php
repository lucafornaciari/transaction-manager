<?php


namespace App\Service\Exporter;


interface ExporterInterface
{
    public function export(array $data, string $filename);
}