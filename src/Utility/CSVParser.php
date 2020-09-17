<?php


namespace App\Utility;


use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Finder\Finder;

class CSVParser
{
    protected const FINDER_DIRECTORY = 'src/Resources/';
    protected const IGNORE_FIRST_LINE = true;

    /**
     * @param string $fileName
     * @param string $directory
     * @param bool $ignoreFirstLine
     *
     * @return array
     */
    public function parse(string $fileName, string $directory = self::FINDER_DIRECTORY, bool $ignoreFirstLine = self::IGNORE_FIRST_LINE)
    {
        $finder = new Finder();
        $finder->files()
            ->in($directory)
            ->name($fileName)
        ;

        if (!$finder->hasResults()) {
            throw new FileNotFoundException('File ' . $directory.$fileName . ' not found');
        }

        foreach ($finder as $file) {
            $csv = $file;
        }

        $rows = [];
        if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ";")) !== FALSE) {
                $i++;
                if ($ignoreFirstLine && $i == 1) {
                    continue;
                }

                $rows[] = $data;
            }
            fclose($handle);
        }

        return $rows;
    }
}