# Composer Dependency List Bundle

Integrates [frostiede/composer-dependency-list](https://github.com/frostieDE/composer-dependency-list) with Symfony 3 or 4.

# Installation

```
$ composer require frostiede/composer-dependency-list-bundle
```

Important: If you use Symfony 3.x, you also need to enable the bundle in your `AppKernel.php`.

# Configuration
```yaml
composer_dependency_list:
    lock_file: "%kernel.project_dir%/composer.lock"
    list_template: "@ComposerDependencyList/list.html.twig"
    license_template: "@ComposerDependencyList/license.html.twig"
```

* `lock_file`: Path to your `composer.lock` file.
* `list_template`: Twig template which is used to render the list of dependencies.
* `license_template`: Twig template which is used to render the license.

# Contribution

Feel free to contribute

# Contribution

Feel free to contribute :-)

# License

MIT