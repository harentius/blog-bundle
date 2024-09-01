<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

#[ORM\Entity(repositoryClass: \Harentius\BlogBundle\Entity\AdminUserRepository::class)]
class AdminUser implements UserInterface, \Serializable
{
    use IdentifiableEntityTrait;

    /**
     * @var string|null
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 50, unique: true)]
    #[SymfonyConstraints\NotBlank]
    #[SymfonyConstraints\Length(max: 50)]
    #[SymfonyConstraints\Type('string')]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[SymfonyConstraints\NotBlank]
    #[SymfonyConstraints\Length(max: 255)]
    #[SymfonyConstraints\Type('string')]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[SymfonyConstraints\NotBlank]
    #[SymfonyConstraints\Length(max: 255)]
    #[SymfonyConstraints\Type('string')]
    private $plainPassword;

    /**
     * @var string
     */
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[SymfonyConstraints\NotBlank]
    #[SymfonyConstraints\Length(max: 255)]
    #[SymfonyConstraints\Type('string')]
    private ?string $salt = null;

    /**
     *
     */
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->username;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setUsername(?string $value): self
    {
        $this->username = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setPassword(?string $value): self
    {
        $this->password = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setPlainPassword(?string $value): self
    {
        $this->plainPassword = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return ['ROLE_ADMIN', 'ROLE_SONATA_ADMIN'];
    }

    /**
     *
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ] = unserialize($serialized);
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->getId();
    }
}
