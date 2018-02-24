<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Element\NodeElement;

class SonataListContext implements Context
{
    /**
     * @var MinkContext
     */
    private $minkContext;

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function gatherContexts(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->minkContext = $environment->getContext(MinkContext::class);
    }

    /**
     * @Given /^I click on "([^"]*)" action for entity with "([^"]*)" "([^"]*)"$/
     * @param string $actionLocator
     * @param string $cellName
     * @param string $cellValue
     */
    public function iClickForEntityWith(string $actionLocator, string $cellName, string $cellValue): void
    {
        $rowElement = $this->getRowByCellValue($cellName, $cellValue);
        $actionColumnIndex = $this->getCellIndex('Action');
        $cellElement = $this->getCellInRowByIndex($rowElement, $actionColumnIndex);
        $actionElement = $cellElement->find('named', ['link', $actionLocator]);

        if (!$actionElement) {
            throw new \InvalidArgumentException(sprintf("Action '%s' not found", $actionLocator));
        }

        $actionElement->click();
    }

    /**
     * @param string $cellName
     * @param string $cellValue
     * @return NodeElement
     */
    private function getRowByCellValue(string $cellName, string $cellValue): NodeElement
    {
        $index = $this->getCellIndex($cellName);
        $tableRowElements = $this->minkContext->getSession()->getPage()->findAll('css', 'table tr');
        // Skipping header
        array_shift($tableRowElements);

        /** @var NodeElement $tableRowElement */
        foreach ($tableRowElements as $tableRowElement) {
            $cellElement = $this->getCellInRowByIndex($tableRowElement, $index);

            if (trim($cellElement->getText()) === $cellValue) {
                return $tableRowElement;
            }
        }

        throw new InvalidArgumentException(sprintf("Row with column '%s' value '%s' not found", $cellName, $cellValue));
    }

    /**
     * @param NodeElement $rowElement
     * @param int $index
     * @return NodeElement
     */
    private function getCellInRowByIndex(NodeElement $rowElement, int $index): NodeElement
    {
        $cellElements = $rowElement->findAll('css', 'td');
        $i = 0;

        foreach ($cellElements as $cellElement) {
            $i++;

            if ($i === $index) {
                return $cellElement;
            }
        }

        throw new InvalidArgumentException(sprintf("Cell with index '%d' not found", $index));
    }

    /**
     * @param string $cellName
     * @return int|null
     */
    private function getCellIndex(string $cellName): ?int
    {
        $columnNameElements = $this->minkContext->getSession()->getPage()->findAll('css', 'table th');
        $index = 0;

        /** @var NodeElement $columnNameElement */
        foreach ($columnNameElements as $columnNameElement) {
            $index++;

            if (trim($columnNameElement->getText()) === $cellName) {
                return $index;
            }
        }

        throw new \InvalidArgumentException(sprintf("Index for column '%s' not found"));
    }
}
