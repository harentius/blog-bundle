<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Admin\Admin;

use Harentius\BlogBundle\Admin\Admin\CategoryAdmin;
use Harentius\BlogBundle\Test\SonataAdminClassTestCase;

class CategoryAdminTest extends SonataAdminClassTestCase
{
    public function testConfigureListFields(): void
    {
        $articleAdmin = $this->createAdmin(CategoryAdmin::class);
        $this->assertHasListFields($articleAdmin, [
            'name',
            'slug',
            'parent',
            'children',
            'metaDescription',
            'metaKeywords',
            '_action',
        ]);
    }

    public function testConfigureFormFields(): void
    {
        $articleAdmin = $this->createAdmin(CategoryAdmin::class);
        $this->assertHasFormFields($articleAdmin, [
            'name',
            'slug',
            'parent',
            'metaDescription',
            'metaKeywords',
        ]);
    }
}
