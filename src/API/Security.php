<?php

namespace Harentius\BlogBundle\API;

use Harentius\BlogBundle\Entity\ApiKeyRepository;

class Security
{
    public function __construct(
        private readonly ApiKeyRepository $apiKeyRepository,
    ) {
    }

    public function isApiTokenValid(string $apiToken): bool
    {
        $decoded = base64_decode($apiToken, true);
        $exploded = explode(':', $decoded);

        if (count($exploded) !== 2) {
            return false;
        }

        $apiKey = $this->apiKeyRepository->findOneBy(['apiKey' => $exploded[0]]);

        if (!$apiKey) {
            return false;
        }

        return $apiKey->isSecretValid($exploded[1]);
    }
}
