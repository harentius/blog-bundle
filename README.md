Symfony Blog Bundle
===================

[![Build Status](https://travis-ci.org/harentius/blog-bundle.svg?branch=master)](https://travis-ci.org/harentius/blog-bundle)
[![Maintainability](https://api.codeclimate.com/v1/badges/8a118f94722e7ac4dc70/maintainability)](https://codeclimate.com/github/harentius/blog-bundle/maintainability)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a92cb57e-8b8f-4edc-b12f-06f5e9911d7b/mini.png)](https://insight.sensiolabs.com/projects/a92cb57e-8b8f-4edc-b12f-06f5e9911d7b)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harentius/blog-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/harentius/blog-bundle/?branch=master)

Engine for creating simple blog or adding one to the existing project


Symfony Bundle for simple blog. In active development now.

This doc explains integration in existing project, which requires a lot of work. Currently I working on improvement and simplification of this process. You're welcome to report issues

For quick and easy stand-alone installation please check [https://github.com/harentius/blog](https://github.com/harentius/blog)


Installation
------------

Version <= v1.1.9 tested on symfony 2.7 and 2.8.
Version >= 2.0.0 supports symfony >= 3.0
Can be used it in existing project, but depends of complexity of project integration/dependency problems can happen.
Fill free to create issue/pull request with problem description

For stand-alone installation, install symfony >= 3.0 first:

```bash
composer.phar create-project symfony/framework-standard-edition test
```

For using in existing project skip this step.

Than install bundle:

```bash
$ composer.phar require harentius/blog-bundle
```


2) Enable bundles in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
        new Sonata\CoreBundle\SonataCoreBundle(),
        new Sonata\BlockBundle\SonataBlockBundle(),
        new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
        new Sonata\AdminBundle\SonataAdminBundle(),
        new Sonata\TranslationBundle\SonataTranslationBundle(),
        new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
        new Presta\SitemapBundle\PrestaSitemapBundle(),
        new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
        new Eko\FeedBundle\EkoFeedBundle(),
        new Liip\ImagineBundle\LiipImagineBundle(),
        new Hautelook\AliceBundle\HautelookAliceBundle(),

        new Harentius\BlogBundle\HarentiusBlogBundle(),
    );

    // ...
}
```


3) Include configuration and routing:
There are lot of predefined configuration, very basic. You can use you own, it is just examples.
(Used to configure SonataAdminBundle and Security)

### Configuration

app/config/config.yml:

```yml
imports:
...
    - { resource: "@HarentiusBlogBundle/Resources/config/config.yml" }
    - { resource: "@HarentiusBlogBundle/Resources/config/security.yml" }
```

You can use your own security configuration or predefined by HarentiusBlogBundle. In last case, you should remove:

```yml
imports:
...
    - { resource: security.yml }
```

(Because Symfony demands to store security configuration in one file.)

### Routing:

```yml
blog:
    resource: "@HarentiusBlogBundle/Resources/config/routing.yml"
    prefix:   /

admin:
    resource: "@HarentiusBlogBundle/Resources/config/routing-admin.yml"
    prefix:   /admin
```

4) Configure:

```yml
harentius_blog:
    # Localizations to be used by blog
    locales: ['en', 'ua']
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
            number: 6
    list:
        posts_per_page: 20
    # For avoiding internal apc cache conflicts if run multiple sites on one server.
    cache:
        apc_global_prefix: blog
        statistics_cache_lifetime: 3600
```


5) Create/Update your DB according to chosen installation type

```bash
bin/console doctrine:database:create
bin/console doctrine:schema:create
```

or

```bash
bin/console doctrine:schema:update
```


6) Populate initial DB values (admin user default credentials: admin/admin, homepage data, etc)

```bash
bin/console hautelook_alice:doctrine:fixtures:load
```

7) Install Assets

```bash
bin/console assets:dump
bin/console assets:install
```

Resources
---------

[https://folkprog.net](https://folkprog.net) - example of blog (currently working project that uses this bundle)

[https://github.com/harentius/folkprog](https://github.com/harentius/folkprog) - repository of this project


TODO:

    1) Remove VK dependency/make it optional, same for sharing buttons
    
    2) Improve file uploading
    
    3) Write tests
