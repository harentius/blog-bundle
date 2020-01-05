<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

/**
 * @ORM\Entity(repositoryClass="Harentius\BlogBundle\Entity\SettingRepository")
 */
class Setting
{
    use IdentifiableEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="_key")
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\NotBlank()
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @SymfonyConstraints\Type(type="string")
     * @SymfonyConstraints\Length(max=255)
     * @SymfonyConstraints\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @SymfonyConstraints\Type(type="string")
     */
    private $value;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setKey($value)
    {
        $this->key = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
