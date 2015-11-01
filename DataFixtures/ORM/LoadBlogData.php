<?php

namespace Harentius\BlogBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class LoadBlogData extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__ . '/blog_data.yml',
        ];
    }

    public function getAdminUser()
    {
        return $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('HarentiusBlogBundle:AdminUser')
            ->findOneBy(['username' => 'admin'])
        ;
    }
}
