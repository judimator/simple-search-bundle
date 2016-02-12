<?php

namespace Ju\SimpleSearchBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class FindFileCommandTest extends WebTestCase
{

    public static $application;

    public function testCommandShell()
    {
        $dir = str_replace('\\', '\\\\', __DIR__);

        $output = self::runCommand(sprintf('find jumagaliev %s\\\\Fixtures\\\\dir1 %s\\\\Fixtures\\\\dir2', $dir, $dir));
        $this->assertRegexp('~dir1\\\\test2\.txt~', $output);

        $output = self::runCommand(sprintf('find jumagaliev %s\\\\Fixtures\\\\dir1 %s\\\\Fixtures\\\\dir2 --engine=ju_engine --pattern=^test3', $dir, $dir));
        $this->assertRegexp('~dir1\\\\test3\.txt~', $output);
    }

    public static function runCommand($command)
    {
        $fp = tmpfile();
        $input = new StringInput($command);
        $output = new StreamOutput($fp);
        self::getApplication()->run($input, $output);

        fseek($fp, 0);
        $output = '';

        while (!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;

    }

    public static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

}
