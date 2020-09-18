<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ReportCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('generate-report');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['customerId' => 1]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('CSV was generated', $output);
    }
}