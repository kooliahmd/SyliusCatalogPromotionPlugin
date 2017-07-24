<?php

namespace SnakeTn\CatalogPromotion;

use SnakeTn\CatalogPromotion\DependencyInjection\Compiler\RegisterActionExecutorsPass;
use SnakeTn\CatalogPromotion\DependencyInjection\Compiler\RegisterRuleCheckersPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class CatalogPromotionPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterRuleCheckersPass());
        $container->addCompilerPass(new RegisterActionExecutorsPass());
    }
}
