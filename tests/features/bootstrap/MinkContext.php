<?php

use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\MinkContext as BaseMinkContext;

class MinkContext extends BaseMinkContext
{
    /**
     * Updated version of MinkContext::checkOption which correctly deal with iCheck fields.
     *
     * {@inheritdoc}
     */
    public function checkOption($option)
    {
        $option = $this->fixStepArgument($option);
        $element = $this->getSession()->getPage()->findField($option);

        if (!$element) {
            throw new \InvalidArgumentException(sprintf("Field '%s' not found", $option));
        }

        $parent = $element->getParent();

        if ($parent && $parent->hasClass('icheckbox_square-blue')) {
            $iCheckElement = $parent->find('css', '.iCheck-helper');

            if (!$iCheckElement) {
                throw new \InvalidArgumentException(sprintf("iCheck element '.iCheck-helper' not found for '%s'", $option));
            }

            $iCheckElement->click();
        } else {
            $element->check();
        }
    }

    /**
     * Updated version of MinkContext::fillField which correctly deal with CKEDITOR fields.
     *
     * {@inheritdoc}
     */
    public function fillField($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        /** @var NodeElement[] $elements */
        $element = $this->getSession()->getPage()->find('named', ['field', $field]);

        if (!$element) {
            throw new \InvalidArgumentException(sprintf("Field '%s' not found", $field));
        }

        if ($element->getTagName() === 'textarea' && $element->hasClass('ckeditor')) {
            $fieldId = $element->getAttribute('id');

            if ($fieldId === null || $fieldId === '') {
                throw new \LogicException(sprintf("Unable to fill in CKEDITOR field '%s' as it's id attribute is missing.", $field));
            }

            $this->getSession()->executeScript(sprintf('CKEDITOR && CKEDITOR.instances["%s"].setData("%s");', $fieldId, $value));
        } else {
            $element->setValue($value);
        }
    }

    /**
     * @When I scroll to ":locator"
     * @param string $locator
     */
    public function scrollIntoView($locator)
    {
        $element = $this->getSession()->getPage()->find('named', ['field', $locator]);
        $xpath = str_replace("\n", '', $element->getXpath());
        $function = "document.evaluate(\"{$xpath}\", document).iterateNext().scrollIntoView();";
        $this->getSession()->executeScript($function);
    }
}
