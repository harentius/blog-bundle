Symfony Blog Bundle
===================

[![codecov](https://codecov.io/gh/harentius/blog-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/harentius/blog-bundle)
[![Maintainability](https://api.codeclimate.com/v1/badges/8a118f94722e7ac4dc70/maintainability)](https://codeclimate.com/github/harentius/blog-bundle/maintainability)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harentius/blog-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/harentius/blog-bundle/?branch=master)

Symfony Bundle for adding simple blog functionality to existing or new Symfony project.

Requirements
------------
Version ^4.0 - Symfony ^4.0, twig/twig:^2.0  
Version ^3.0 - Symfony ^3.0  
Version ^1.0|^2.0 - Symfony ^2.7   


Installation
------------

### 1. With Symfony Flex
TODO

### 2. Without Symfony Flex 
1) Install bundle 
```bash
$ composer.phar require harentius/blog-bundle
```

2) Add bundles (in config/bundles.php or Kernel):

```php
<?php
// config/bundles.php

return [
//...
    Harentius\BlogBundle\HarentiusBlogBundle::class => ['all' => true],
//...
    Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class => ['all' => true],
    Knp\Bundle\PaginatorBundle\KnpPaginatorBundle::class => ['all' => true],
    Knp\Bundle\MenuBundle\KnpMenuBundle::class => ['all' => true],
    WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle::class => ['all' => true],
    Sonata\CoreBundle\SonataCoreBundle::class => ['all' => true],
    Sonata\BlockBundle\SonataBlockBundle::class => ['all' => true],
    Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle::class => ['all' => true],
    Sonata\AdminBundle\SonataAdminBundle::class => ['all' => true],
    Sonata\TranslationBundle\SonataTranslationBundle::class => ['all' => true],
    Sonata\Doctrine\Bridge\Symfony\Bundle\SonataDoctrineBundle::class => ['all' => true],
    FOS\JsRoutingBundle\FOSJsRoutingBundle::class => ['all' => true],
    Presta\SitemapBundle\PrestaSitemapBundle::class => ['all' => true],
    Eko\FeedBundle\EkoFeedBundle::class => ['all' => true],
    Liip\ImagineBundle\LiipImagineBundle::class => ['all' => true],
    Hautelook\AliceBundle\HautelookAliceBundle::class => ['all' => true],
    Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle::class => ['all' => true],
    Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle::class => ['all' => true],
];
```
*Please note that HarentiusBlogBundle can provide default configuration for other bundles.  
To make this work, HarentiusBlogBundle should be registered before other bundles*

*HarentiusBlogBundle also has default security config. So please make sure it does not conflict with your app config or skip using it*


3) Include routes:
```yml
# config/routes.yaml
blog:
    resource: "@HarentiusBlogBundle/Resources/config/routing.yml"
    prefix: /
```

4) Include default configs:  
*Note: this step can be skipped if you decide to configure bundles (i.e. DoctrineBundle, SecurityBundle, etc) yourself*

```yml
# config/packages/harentius_blog.yaml
imports:
    - { resource: '@HarentiusBlogBundle/Resources/config/config.yml' }
```

### Configuration
Config reference:

```yml
harentius_blog:
    # Localizations to be used by blog
    locales: ['en', 'uk']
    primary_locale: 'en'
    articles:
        # Path where previews stored
        image_previews_base_uri: /assets/images/preview/
    sidebar:
        # ~ - no cache, 0 - unlimited cache
        cache_lifetime: 3600
        # Max tags number (ordered by max popularity)
        tags_limit: 10
        # Percent tags size, unlimited variants number (valid values: [50, 100], [25, 50, 75, 100], etc)
        tag_sizes: [65, 80, 100]
    homepage:
        # ~ - no page, feed only or page slug
        page_slug: index
        # ~ - no feed
        feed:
            # ~ - all
            category: ~
            # Last articles number
            number: 5
    list:
        posts_per_page: 20
    # For avoiding internal apc cache conflicts if run multiple sites on one server.
    cache:
        apc_global_prefix: blog
```

### Post Installation/Configuration actions
1) Create/Update your DB according to chosen installation type
```bash
bin/console doctrine:database:create # If fresh installation
bin/console doctrine:schema:create
```

2) Install assets
```bash
bin/console assets:install --symlink
```

3) Load fixtures (optional)
```bash
bin/console hautelook:fixtures:load
```

Additional Resources
====================

[https://folkprog.net](https://folkprog.net) - example of blog based on this bundle.

[https://github.com/harentius/folkprog](https://github.com/harentius/folkprog) - git repository with sources of this blog.
