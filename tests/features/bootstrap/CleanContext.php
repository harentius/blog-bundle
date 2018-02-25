<?php

use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelDictionary;

class CleanContext implements Context
{
    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function beforeScenario(): void
    {
        $this->getContainer()->get('harentius_blog.router.category_slug_provider')->clearAll();
    }
}
