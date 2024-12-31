# Symfony Blog Bundle

[![codecov](https://codecov.io/gh/harentius/blog-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/harentius/blog-bundle)
[![Maintainability](https://api.codeclimate.com/v1/badges/8a118f94722e7ac4dc70/maintainability)](https://codeclimate.com/github/harentius/blog-bundle/maintainability)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harentius/blog-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/harentius/blog-bundle/?branch=master)

A Symfony Bundle for adding simple blog functionality to existing or new Symfony project.  
Subsplit from [harentius/blog](https://github.com/harentius/blog) minimalistic blogging engine, which is designed to use Markdown files for content and transform them into blogs, and harentius/blog only stores and shows blogs.

## Installation

1. Install the bundle
```bash
$ composer.phar require harentius/blog-bundle
```

2. Add bundles (in config/bundles.php or Kernel):

```php
<?php
// config/bundles.php

return [
//...
    Harentius\BlogBundle\HarentiusBlogBundle::class => ['all' => true],
//...
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class => ['all' => true],
    Knp\Bundle\PaginatorBundle\KnpPaginatorBundle::class => ['all' => true],
];
```

3. Include routes:
```yml
# config/routes.yaml
blog:
    resource: "@HarentiusBlogBundle/Resources/config/routing.yaml"
    prefix:   /
```

4. Include default configs:
*Note: this step can be skipped if you decide to configure bundles (i.e. DoctrineBundle, SecurityBundle, etc) yourself*

```yml
# config/packages/harentius_blog.yaml
imports:
    - { resource: '@HarentiusBlogBundle/Resources/config/config.yaml' }
```

## Configuration
Config reference:

```yml
harentius_blog:
    title: Blog Title
    theme: default|dark # default dark
    highlight_code: true|false # load highlight js library or not, default false
```

5.  Create/Update your DB according to chosen installation type
```bash
bin/console doctrine:database:create
bin/console doctrine:schema:create
```

6. Install assets
```bash
bin/console assets:install
```
