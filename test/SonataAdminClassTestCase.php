<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Test;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Builder\FormContractorInterface;
use Sonata\AdminBundle\Route\RouteGeneratorInterface;
use Sonata\AdminBundle\Translator\NoopLabelTranslatorStrategy;
use Sonata\DoctrineORMAdminBundle\Builder\ListBuilder;
use Sonata\DoctrineORMAdminBundle\Guesser\TypeGuesser;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SonataAdminClassTestCase extends TestCase
{
    public function assertHasListFields(AbstractAdmin $abstractAdmin, array $fields): void
    {
        $list = $abstractAdmin->getList();
        $elements = $list->getElements();
        $this->assertArraysSame(array_keys($elements), $fields);
    }

    public function assertHasFormFields(AbstractAdmin $abstractAdmin, array $fields): void
    {
        $list = $abstractAdmin->getFormFieldDescriptions();
        $this->assertArraysSame(array_keys($list), $fields);
    }

    protected function createAdmin(string $class): AbstractAdmin
    {
        if (!is_subclass_of($class, AbstractAdmin::class)) {
            throw new \InvalidArgumentException("Class '{$class}' is not subclass of 'AbstractAdmin'");
        }

        /** @var AbstractAdmin $admin */
        $admin = new $class('', '', '');
        $listBuilder = new ListBuilder(new TypeGuesser());

        $admin->setListBuilder($listBuilder);
        $admin->setRouteGenerator($this->createMock(RouteGeneratorInterface::class));
        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $metadataFactory = $this->createMock(MetadataFactoryInterface::class);
        $metadataFactory
            ->method('getMetadataFor')
            ->willReturn($this->createMock(ClassMetadata::class))
        ;
        $entityManager
            ->method('getMetadataFactory')
            ->willReturn($metadataFactory)
        ;
        $managerRegistry
            ->method('getManagerForClass')
            ->willReturn($entityManager)
        ;
        $modelManager = new ModelManager($managerRegistry);
        $admin->setModelManager($modelManager);
        $admin->setLabelTranslatorStrategy(new NoopLabelTranslatorStrategy());
        $formContractor = $this->createMock(FormContractorInterface::class);
        $formContractor->method('getFormBuilder')->willReturn($this->createMock(FormBuilderInterface::class));
        $admin->setFormContractor($formContractor);
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getMetadataFor')->willReturn($this->createMock(ValidatorClassMetadata::class));
        $admin->setValidator($validator);

        return $admin;
    }

    private function assertArraysSame(array $array, array $arraySubset): void
    {
        $this->assertTrue(empty(array_diff($arraySubset, $array)) && empty(array_diff($array, $arraySubset)));
    }
}
