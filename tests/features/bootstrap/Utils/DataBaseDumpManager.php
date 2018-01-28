<?php

namespace Utils;

use Symfony\Component\Process\Process;

class DataBaseDumpManager
{
    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @return string|null
     */
    public function dump()
    {
        $output = $this->runBin('test-database-dump', uniqid('', true));

        if (preg_match('/ to \'(?<file>.+)\'$/', $output, $matches)) {
            return $matches['file'];
        }

        throw new \RuntimeException("Can't create database dump");
    }

    /**
     * @param $dumpFile
     */
    public function load($dumpFile)
    {
        $this->runBin('test-database-import', $dumpFile);
    }

    /**
     * @param string $bin
     * @param string $args
     * @return string
     */
    private function runBin($bin, $args)
    {
        $process = new Process(sprintf('%s/bin/%s %s', $this->rootDir, $bin, $args));
        $process->run();

        return $process->getOutput();
    }
}
