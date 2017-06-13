<?php
/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kooli\CatalogPromotion\Promotion;


use Doctrine\Common\Collections\ArrayCollection;
use Kooli\CatalogPromotion\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Promotion\Model\PromotionRuleInterface;

class PromotionEligibilityFilter
{
    /**
     * @var RuleCheckerInterface
     */
    private $hasTaxonRuleChecker;


    public function __construct(RuleCheckerInterface $hasTaxonRuleChecker)
    {
        $this->hasTaxonRuleChecker = $hasTaxonRuleChecker;
    }

    /**
     * @param ArrayCollection|ProductVariantInterface[] $productVariants
     * @param ArrayCollection|PromotionRuleInterface[] $rules
     */
    public function filter(ArrayCollection $productVariants, ArrayCollection $rules)
    {
        foreach ($rules as $rule) {
            foreach ($productVariants as $key => $productVariant) {
                if (!$this->getCheckerPerRuleType($rule->getType())->isEligible($productVariant, $rule)) {
                    $productVariants->remove($key);
                }
            }
        }
    }

    /**
     * @param $ruleType
     * @return RuleCheckerInterface
     * @throws \Exception
     */
    public function getCheckerPerRuleType($ruleType): RuleCheckerInterface
    {
        switch ($ruleType) {
            case 'has_taxon' :
                return $this->hasTaxonRuleChecker;
        }
        throw new \Exception();
    }


}
