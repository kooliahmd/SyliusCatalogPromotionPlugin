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

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Promotion\Model\PromotionRuleInterface;

interface RuleCheckerInterface
{
    /**
     * @param ProductVariantInterface $productVariant
     * @param PromotionRuleInterface $rule
     * @return boolean
     */
    public function isEligible(ProductVariantInterface $productVariant, PromotionRuleInterface $rule);
}
