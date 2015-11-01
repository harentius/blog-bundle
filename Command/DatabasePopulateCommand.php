<?php

namespace Harentius\BlogBundle\Command;

use Harentius\BlogBundle\Entity\AdminUser;
use Harentius\BlogBundle\Entity\Setting;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabasePopulateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('blog:database:populate')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $encoder = $this->getContainer()->get('security.password_encoder');
        $entitiesForPersisting = [];

        // TODO: Refactor
        // Admin user
        if (!$em->getRepository('HarentiusBlogBundle:AdminUser')->findOneBy(['username' => 'admin'])) {
            $adminUser = new AdminUser();
            $adminUser
                ->setUsername('admin')
                ->setPassword($encoder->encodePassword($adminUser, 'admin'));

            $entitiesForPersisting[] = $adminUser;
        }

        // Settings
        if (!$em->getRepository('HarentiusBlogBundle:Setting')->findOneBy(['key' => 'project_name'])) {
            $setting = new Setting();
            $setting
                ->setKey('project_name')
                ->setName('Project Name')
                ->setValue('Simple Symfony Blog')
            ;

            $entitiesForPersisting[] = $setting;
        }

        if (!$em->getRepository('HarentiusBlogBundle:Setting')->findOneBy(['key' => 'homepage_meta_description'])) {
            $setting = new Setting();
            $setting
                ->setKey('homepage_meta_description')
                ->setName('Homepage Meta Description')
                ->setValue('Simple Symfony Blog description')
            ;

            $entitiesForPersisting[] = $setting;
        }

        if (!$em->getRepository('HarentiusBlogBundle:Setting')->findOneBy(['key' => 'homepage_meta_keywords'])) {
            $setting = new Setting();
            $setting
                ->setKey('homepage_meta_keywords')
                ->setName('Homepage Meta Keywords')
                ->setValue('symfony blog')
            ;

            $entitiesForPersisting[] = $setting;
        }

        foreach ($entitiesForPersisting as $entity) {
            $em->persist($entity);
            $em->flush($entity);
        }
    }
}
