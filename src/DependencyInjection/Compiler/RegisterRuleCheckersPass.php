<?php

namespace SnakeTn\CatalogPromotion\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterRuleCheckersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $promotionRuleCheckerTypeToLabelMap = [];
        foreach ($container->findTaggedServiceIds('catalog-promotion.rule-checker') as $id => $attributes) {
            $promotionRuleCheckerTypeToLabelMap[$attributes[0]['type']] = $attributes[0]['label'];
        }
        $container->setParameter('catalog-promotion.promotion_rules', $promotionRuleCheckerTypeToLabelMap);
    }
}
