<?php

use Behat\Behat\Context\Context;
use Utils\DataBaseDumpManager;

class BackUpContext implements Context
{
    /**
     * @var string|null
     */
    private static $dumpFile;

    /**
     * @var DataBaseDumpManager
     */
    private static $dataBaseDumpManager;

    /**
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        self::$dataBaseDumpManager = new DataBaseDumpManager($rootDir);

        if (!self::$dumpFile) {
            self::$dumpFile = self::$dataBaseDumpManager->dump();
        }
    }

    /**
     * @AfterSuite
     */
    public static function tearDown()
    {
        self::$dataBaseDumpManager->load(self::$dumpFile);

        if (self::$dumpFile !== null) {
            unlink(self::$dumpFile);
        }
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        self::$dataBaseDumpManager->load(self::$dumpFile);
    }
}
