<?php

namespace Harentius\BlogBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\AdminUserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AdminUserPasswordChangeCommand extends Command
{
    protected static $defaultName = 'blog:admin-user-password:change';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AdminUserRepository
     */
    private $adminUserRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(EntityManagerInterface $entityManager, AdminUserRepository $adminUserRepository)
    {
        $this->entityManager = $entityManager;
        $this->adminUserRepository = $adminUserRepository;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->addArgument('password', InputArgument::REQUIRED)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adminUser = $this->adminUserRepository->findOneBy(['username' => 'admin']);

        if (!$adminUser) {
            throw new \RuntimeException('Admin User not found');
        }

        $adminUser->setPlainPassword($input->getArgument('password'));
        $this->entityManager->flush();

        $output->writeln('Password successfully changed');
    }
}
