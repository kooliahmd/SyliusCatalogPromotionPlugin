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
            new SnakeTn\CatalogPromotion\CatalogPromotionPlugin(),
            new \Sylius\Bundle\AdminBundle\SyliusAdminBundle(),
            new \Sylius\Bundle\ShopBundle\SyliusShopBundle(),
            new \Liip\FunctionalTestBundle\LiipFunctionalTestBundle()
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
