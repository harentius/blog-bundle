<?php

namespace Harentius\BlogBundle\Command;

use Harentius\BlogBundle\Entity\AdminUser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AdminUserPasswordChangeCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('blog:admin-user-password:change')
            ->addArgument('password', InputArgument::REQUIRED)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $encoder = $this->getContainer()->get('security.password_encoder');

        if ($adminUser = $em->getRepository('HarentiusBlogBundle:AdminUser')->findOneBy(['username' => 'admin'])) {
            $adminUser->setPassword($encoder->encodePassword($adminUser, $input->getArgument('password')));
            $em->flush();
        }

        $output->writeln('Password successfully changed');
    }
}
