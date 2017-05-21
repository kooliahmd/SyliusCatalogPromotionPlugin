<?php

namespace Kooli\CatalogPromotion\Promotion\Checker\Rule;


use Kooli\CatalogPromotion\Model\ChannelPricing;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

class HasTaxonRuleChecker implements RuleCheckerInterface
{
    public function isEligible(PromotionSubjectInterface $subject, array $configuration)
    {
        /** @var ChannelPricing $subject */
        /** @var Taxon $taxon */
        foreach ($subject->getProductVariant()->getProduct()->getTaxons() as $taxon) {
            if (in_array($taxon->getCode(), $configuration['taxons'], true)) {
                return true;
            }
        };
        return false;
    }

}
