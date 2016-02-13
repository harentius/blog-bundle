Just another Symfony blog bundle
================================

Symfony Bundle for simple blog.

In progress now.


Installation
------------

1) Tested using with Symfony 2.7 (and written using this version).
Theoretically you can use it in existing project.

For stand-alone installation, install symfony 2.7 first:

```bash
composer create-project symfony/framework-standard-edition test "2.7.*"
```

For using in existing project skip this step.

Because of using bower-asset/ckeditor-more-plugin in admin section with dev-master, for installing HarentiusBlogBundle you should set

```json
   "minimum-stability": "dev",
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
app/console blog:database:populate
```


Resources
---------

[http://folkprog.net](http://folkprog.net) - example of blog (currently working project that uses this bundle)

[https://github.com/harentius/folkprog](https://github.com/harentius/folkprog) - repository of this project


TODO: remove/improve dependency bower-asset/ckeditor-more-plugin to avoid requirement of "minimum-stability": "dev"
