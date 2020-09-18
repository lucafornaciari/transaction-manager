<?php


namespace App\Tests\Service\Exporter;


use App\Exception\ExporterNotFoundException;
use App\Service\Exporter\CsvExporter;
use App\Service\Exporter\ExporterFactory;
use App\Service\Exporter\ExporterInterface;
use PHPUnit\Framework\TestCase;

class ExporterFactoryTest extends TestCase
{
    /** @var ExporterFactory */
    protected $exporterFactory;

    public function setUp()
    {
        $csvExporter = $this->createMock(CsvExporter::class);
        $this->exporterFactory = new ExporterFactory($csvExporter);
    }

    /**
     * @dataProvider getExporterDataProvider
     *
     * @param string $exporterType
     * @param string $expectedEporterClass
     * @throws ExporterNotFoundException
     */
    function testGetExporter(string $exporterType, string $expectedEporterClass)
    {
        $exporter = $this->exporterFactory->getExporter($exporterType);

        $this->assertInstanceOf(ExporterInterface::class, $exporter);
        $this->assertInstanceOf($expectedEporterClass, $exporter);
    }

    public function getExporterDataProvider()
    {
        return [
            [ExporterFactory::CSV_EXPORT, CsvExporter::class]
        ];
    }

    /**
     * @throws ExporterNotFoundException
     */
    public function testExporterNotFoundException()
    {
        $this->expectException(ExporterNotFoundException::class);

        $this->exporterFactory->getExporter('TXT');
    }
}