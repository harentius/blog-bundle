<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApiKeyRepository::class)]
class ApiKey
{
    use IdentifiableEntityTrait;
    use TimestampableEntityTrait;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    private string $apiKey;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    private string $secret;

    public function __construct(string $apiKey, string $secret)
    {
        $this->apiKey = $apiKey;
        $this->secret = password_hash($secret, \PASSWORD_DEFAULT);
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getHashedSecret(): string
    {
        return $this->secret;
    }

    public function isSecretValid($rawSecret): string
    {
        return password_verify($rawSecret, $this->secret);
    }
}
