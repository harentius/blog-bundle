<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class AuthContext implements Context
{
    /**
     * @var MinkContext
     */
    private $minkContext;

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->minkContext = $environment->getContext(MinkContext::class);
    }

    /**
     * @Given /^I login as admin$/
     */
    public function iLoginAsAdmin()
    {
        $this->minkContext->visit('/admin/login');
        $this->minkContext->fillField('username or email', 'admin');
        $this->minkContext->fillField('password', 'admin');
        $this->minkContext->pressButton('Log in');
    }
}
