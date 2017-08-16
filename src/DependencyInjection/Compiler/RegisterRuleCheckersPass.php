<?php

namespace SnakeTn\CatalogPromotion\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterRuleCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $promotionRuleCheckerRegistry = $container->getDefinition('catalog-promotion.registry_promotion_rule_checker');
        $promotionRuleCheckerFormTypeRegistry = $container->getDefinition('catalog-promotion.form_registry.promotion_rule_checker');
        $processor = $container->findDefinition('catalog-promotion.processor');
        $promotionRuleCheckerTypeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('catalog-promotion.rule-checker') as $id => $attributes) {
            $promotionRuleCheckerTypeToLabelMap[$attributes[0]['type']] = $attributes[0]['label'];
            $promotionRuleCheckerRegistry->addMethodCall('register', [$attributes[0]['type'], new Reference($id)]);
            $promotionRuleCheckerFormTypeRegistry->addMethodCall('add', [$attributes[0]['type'], 'default', $attributes[0]['form-type']]);
            $processor->addMethodCall('addRuleChecker', [$attributes[0]['type'], new Reference($id)]);
        }
        $container->setParameter('catalog-promotion.promotion_rules', $promotionRuleCheckerTypeToLabelMap);
    }
}
