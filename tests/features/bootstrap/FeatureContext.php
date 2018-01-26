<?php

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{
    /**
     * @Given /^I login as admin$/
     */
    public function iLoginAsAdmin()
    {
        $this->visit('/admin');
    }
}
