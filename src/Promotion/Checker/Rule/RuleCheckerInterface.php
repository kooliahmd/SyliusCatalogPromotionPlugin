<?php

/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kooli\CatalogPromotion\Promotion\Checker\Rule;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Promotion\Model\PromotionRuleInterface;

interface RuleCheckerInterface
{
    public function isEligible(ProductVariantInterface $productVariant, PromotionRuleInterface $rule);
}
