<?php

namespace Harentius\BlogBundle\API;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\ApiKey;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'harentius:blog-bundle:create-api-key')]
class APIKeyGenerateCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $key = bin2hex(random_bytes(16));
        $secret = bin2hex(random_bytes(32));
        $apiKey = new ApiKey($key, $secret);
        $this->entityManager->persist($apiKey);
        $this->entityManager->flush();
        $output->writeln(sprintf('Created API key <info>%s</info> with secret <info>%s</info>', $key, $secret));
        $output->writeln(sprintf('api-token: <info>%s</info>', base64_encode("$key:$secret")));

        return Command::SUCCESS;
    }
}
