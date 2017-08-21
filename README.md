# Catalog promotion plugin for sylius #

## About ##
Catalog promotion is a *sylius* plugin used to selectively apply promotions on certain products.
The promotion is triggered before a product is placed into the shipping cart.

## Setting up the plugin ##

### 1) Download the plugin ### 
```bash
$ composer require snake-tn/catalog-promotion-plugin

```
### 2) Enable the plugin ###
Enable the plugin by adding the following line in the app/AppKernel.php file of your sylius project:

```php
// app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new \SnakeTn\CatalogPromotion\CatalogPromotionPlugin(),
        ];

        // ...
    }
}
```

### 3) Update routing configuration ###
 Add the following routing config to your app/config/routing.yml file of your sylius project:
 ```yaml
catalog_promotion_admin:
    prefix: /admin
    resource: "@CatalogPromotionPlugin/Resources/config/routing.yml"
 ```
### 3) Update DB schema ###
```bash
$ bin/console doctrine:schema:update --force

```

### 4) Cleare cache ###
```bash
$ bin/console cache:clear

```
