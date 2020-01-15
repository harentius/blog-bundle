<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Admin\Admin;

use Harentius\BlogBundle\Admin\Admin\PageAdmin;
use Harentius\BlogBundle\Test\SonataAdminClassTestCase;

class PageAdminTest extends SonataAdminClassTestCase
{
    public function testConfigureListFields(): void
    {
        $articleAdmin = $this->createAdmin(PageAdmin::class);
        $this->assertHasListFields($articleAdmin, [
            'title',
            'slug',
            'author',
            'published',
            'publishedAt',
            'metaDescription',
            'metaKeywords',
            '_action',
        ]);
    }

    public function testConfigureFormFields(): void
    {
        $articleAdmin = $this->createAdmin(PageAdmin::class);
        $this->assertHasFormFields($articleAdmin, [
            'title',
            'slug',
            'text',
            'published',
            'showInMainMenu',
            'publishedAt',
            'author',
            'metaDescription',
            'metaKeywords',
        ]);
    }
}
