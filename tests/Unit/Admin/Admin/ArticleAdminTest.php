<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Admin\Admin;

use Harentius\BlogBundle\Admin\Admin\ArticleAdmin;
use Harentius\BlogBundle\Test\SonataAdminClassTestCase;

class ArticleAdminTest extends SonataAdminClassTestCase
{
    public function testConfigureListFields(): void
    {
        $articleAdmin = $this->createAdmin(ArticleAdmin::class);
        $this->assertHasListFields($articleAdmin, [
            'title',
            'slug',
            'category',
            'tags',
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
        $articleAdmin = $this->createAdmin(ArticleAdmin::class);
        $this->assertHasFormFields($articleAdmin, [
            'title',
            'slug',
            'category',
            'tags',
            'text',
            'published',
            'publishedAt',
            'author',
            'metaDescription',
            'metaKeywords',
        ]);
    }
}
