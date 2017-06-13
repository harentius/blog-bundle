Just another Symfony blog bundle
================================

Symfony Bundle for simple blog. In progress now.

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

Because of using bower-asset/ckeditor-more-plugin in admin section with dev-master, for installing HarentiusBlogBundle you should set

```json
   "minimum-stability": "dev",
   "prefer-stable": true,
```

in your composer.json. (Should be corrected in future.)

Also configure assets installing path:

```json
    "extra": {
        ...
        "asset-installer-paths": {
            "npm-asset-library": "web/assets/vendor",
            "bower-asset-library": "web/assets/vendor"
        }
    }
```

Install composer assets plugins:

(This is temporary solution, I want to avoid using assetic plugin in future)

```bash
$ composer.phar require fxp/composer-asset-plugin
```

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

Add HarentiusBlogBundle to assetic.bundles config, or allow all by removing line

```yml
bundles:        [ ]
```

4) Configure:

```yml
harentius_blog:
    articles:
        # Is generate preview when resize images in CKEditor
        generate_image_previews: true
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

Configure assetic in following way (need less filter and coffee):

```yml
assetic:
    debug:          "%kernel.debug%"
    use_controller: false
    filters:
        cssrewrite:
            apply_to: "\.css$"
        less:
            node: %nodejs.path%
            node_paths: [%nodejs.modules_path%]
            apply_to: "\.less$"
        coffee:
            bin:       %bin_coffee%
            apply_to:  "\.coffee$"
```


5) Create/Update your DB according to chosen installation type

```bash
app/console doctrine:schema:create
```

or

```bash
app/console doctrine:schema:update
```


6) Populate initial DB values (admin user default credentials: admin/admin, homepage data, etc)

```bash
app/console hautelook_alice:doctrine:fixtures:load
```


Resources
---------

[http://folkprog.net](https://folkprog.net) - example of blog (currently working project that uses this bundle)

[https://github.com/harentius/folkprog](https://github.com/harentius/folkprog) - repository of this project


TODO:
    1) Remove/improve dependency bower-asset/ckeditor-more-plugin to avoid requirement of "minimum-stability": "dev"
    2) Remove VK dependency/make it optional, same for sharing buttons
    3) Improve file uploading
