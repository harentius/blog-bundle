<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Admin\Admin;

use Harentius\BlogBundle\Admin\Admin\TagAdmin;
use Harentius\BlogBundle\Test\SonataAdminClassTestCase;

class TagAdminTest extends SonataAdminClassTestCase
{
    public function testConfigureListFields(): void
    {
        $articleAdmin = $this->createAdmin(TagAdmin::class);
        $this->assertHasListFields($articleAdmin, [
            'name',
            'slug',
            '_action',
        ]);
    }

    public function testConfigureFormFields(): void
    {
        $articleAdmin = $this->createAdmin(TagAdmin::class);
        $this->assertHasFormFields($articleAdmin, [
            'name',
            'slug',
        ]);
    }
}
