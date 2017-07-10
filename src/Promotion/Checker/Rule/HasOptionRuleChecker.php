<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 7/6/17
 * Time: 5:15 PM
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
