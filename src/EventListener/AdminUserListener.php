<?php

namespace Harentius\BlogBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Harentius\BlogBundle\Entity\AdminUser;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserListener
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $this->processPasswordEncodingIfNeeded($event);
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->processPasswordEncodingIfNeeded($event);
    }

    /**
     * @param LifecycleEventArgs $event
     */
    private function processPasswordEncodingIfNeeded(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof AdminUser) {
            return;
        }

        $plainPassword = $entity->getPlainPassword();

        if ($plainPassword === null) {
            return;
        }

        $entity->setPassword($this->passwordEncoder->encodePassword($entity, $plainPassword));
    }
}
