<?php

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Tester\Result\TestResult;

class ScreenShotAfterFailContext extends RawMinkContext
{
    /**
     * @AfterStep
     * @param AfterStepScope $scope
     */
    public function takeScreenShotAfterFailedStep(AfterStepScope $scope)
    {
        if ($scope->getTestResult()->getResultCode() !== TestResult::FAILED) {
            return;
        }

        $driver = $this->getSession()->getDriver();

        if (!($driver instanceof Selenium2Driver)) {
            return;
        }

        $fileName = basename($scope->getFeature()->getFile()) . '_' . $scope->getStep()->getLine();
        file_put_contents($this->getScreenShotDir() . $fileName . '.png', $this->getSession()->getDriver()->getScreenshot());
    }

    /**
     * @return string
     */
    private function getScreenShotDir()
    {
        return '/app/tests/app/var/screens/';
    }
}
