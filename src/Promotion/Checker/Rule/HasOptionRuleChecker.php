<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace SnakeTn\CatalogPromotion\Promotion\Checker\Rule;


use SnakeTn\CatalogPromotion\Entity\PromotionRule;
use Sylius\Component\Core\Model\ProductVariantInterface;

class HasOptionRuleChecker implements RuleCheckerInterface
{
    public function isEligible(ProductVariantInterface $productVariant, PromotionRule $rule)
    {
        foreach ($productVariant->getOptionValues() as $optionValue) {
            if (in_array($optionValue->getCode(), $rule->getConfiguration()['option_values'], true)) {
                return true;
            }
        }
        return false;

    }


}
