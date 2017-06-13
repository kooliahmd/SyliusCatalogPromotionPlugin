<?php
use Symfony\Component\Config\Loader\LoaderInterface;
use Sylius\Bundle\CoreBundle\Application\Kernel;

final class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(parent::registerBundles(), [
            new Kooli\CatalogPromotion\CatalogPromotionPlugin(),
            new \Sylius\Bundle\AdminBundle\SyliusAdminBundle(),
            new \Sylius\Bundle\ShopBundle\SyliusShopBundle(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config.yml');
    }
}
