<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SnakeTn\CatalogPromotion\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterActionExecutorsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $promotionActionExecutorRegistry = $container->getDefinition('catalog-promotion.registry_promotion_action_executor');
        $promotionActionExecutorFormTypeRegistry = $container->findDefinition('catalog-promotion.form_registry.promotion_action_executor');
        $processor = $container->findDefinition('catalog-promotion.processor');
        $promotionActionExecutorTypeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('catalog-promotion.action-executor') as $id => $attributes) {
            $promotionActionExecutorTypeToLabelMap[$attributes[0]['type']] = $attributes[0]['label'];
            $promotionActionExecutorFormTypeRegistry->addMethodCall('add', [$attributes[0]['type'], 'default', $attributes[0]['form-type']]);
            $promotionActionExecutorRegistry->addMethodCall('register', [$attributes[0]['type'], new Reference($id)]);
            $processor->addMethodCall('addActionExecutor', [$attributes[0]['type'], new Reference($id)]);
        }
        $container->setParameter('catalog-promotion.promotion_actions', $promotionActionExecutorTypeToLabelMap);
    }

}
