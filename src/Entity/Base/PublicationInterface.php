<?php

namespace Harentius\BlogBundle\Entity\Base;

interface PublicationInterface
{
    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getText();
}
