<?php

namespace Knp\Bundle\RadBundle\Composer;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * Handle post install and update commands of composer
 */
class ScriptHandler
{
    public static function configs()
    {
        static::executeScript('Resources/skeleton/project/bin/configs');
    }

    public static function clearCache()
    {
        static::executeCommand('cache:clear --no-warmup');
    }

    public static function installAssets()
    {
        static::executeCommand('assets:install web');
    }

    protected static function executeCommand($cmd)
    {
        $phpFinder = new PhpExecutableFinder;
        $php = escapeshellcmd($phpFinder->find());

        $process = new Process($php.' app/console '.$cmd);
        $process->run(function ($type, $buffer) { echo $buffer; });
    }

    protected static function executeScript($path)
    {
        $phpFinder = new PhpExecutableFinder;
        $php = escapeshellcmd($phpFinder->find());

        $process = new Process($php.' '.$path);
        $process->run(function ($type, $buffer) { echo $buffer; });
    }
}
