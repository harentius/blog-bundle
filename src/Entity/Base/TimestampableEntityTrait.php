<?php

namespace Harentius\BlogBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as SymfonyConstraints;

trait TimestampableEntityTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @SymfonyConstraints\DateTime
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @SymfonyConstraints\DateTime
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setCreatedAt($value)
    {
        $this->createdAt = $value;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        $this->updatedAt = $value;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
