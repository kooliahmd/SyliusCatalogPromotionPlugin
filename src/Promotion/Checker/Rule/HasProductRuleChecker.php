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

class HasProductRuleChecker implements RuleCheckerInterface
{
    public function isEligible(ProductVariantInterface $productVariant, PromotionRule $rule)
    {
        return in_array($productVariant->getProduct()->getCode(), $rule->getConfiguration()['product_codes'], true);
    }


}