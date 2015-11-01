<?php

namespace Harentius\BlogBundle\Entity;

use Harentius\BlogBundle\Entity\Base\IdentifiableEntityTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\AdminUserRepository")
 */
class AdminUser implements UserInterface, \Serializable
{
    use IdentifiableEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, unique=true)
     * @SymfonyConstraints\NotBlank()
     * @SymfonyConstraints\Length(max=50)
     * @SymfonyConstraints\Type("string")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @SymfonyConstraints\NotBlank()
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\Type("string")

     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @SymfonyConstraints\NotBlank()
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\Type("string")
     */
    private $salt;

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
    public function __toString()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setUsername($value)
    {
        $this->username = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPassword($value)
    {
        $this->password = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSalt($value)
    {
        $this->salt = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN', 'ROLE_SONATA_ADMIN'];
    }

    /**
     *
     */
    public function eraseCredentials()
    {

    }

// TODO: implement
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}
