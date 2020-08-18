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
use SnakeTn\CatalogPromotion\Entity\PromotionRule;
use Sylius\Component\Core\Model\ProductInterface;

class HasTaxonRuleChecker implements RuleCheckerInterface
{
    public function isEligible(ProductVariantInterface $productVariant, PromotionRule $rule)
    {
        return $this->hasProductValidTaxon($productVariant->getProduct(), $rule->getConfiguration());
    }

    private function hasProductValidTaxon(ProductInterface $product, array $configuration)
    {
        foreach ($product->getTaxons() as $taxon) {
            if (in_array($taxon->getCode(), $configuration['taxons'], true)) {
                return true;
            }
        }
        return false;
    }
}
