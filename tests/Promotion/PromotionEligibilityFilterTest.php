<?php
/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Kooli\CatalogPromotion\Promotion;


use Doctrine\Common\Collections\ArrayCollection;
use Kooli\CatalogPromotion\Promotion\Checker\Rule\HasTaxonRuleChecker;
use Kooli\CatalogPromotion\Promotion\PromotionEligibilityFilter;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\ProductTaxon;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\Taxon;
use Sylius\Component\Promotion\Model\PromotionRule;

class PromotionEligibilityFilterTest extends TestCase
{

    /**
     * @var PromotionEligibilityFilter
     */
    private $promotionEligibilityFilter;

    public function setUp()
    {

        $this->promotionEligibilityFilter = new PromotionEligibilityFilter(new HasTaxonRuleChecker());
    }

    public function test_filter_case_not_eligible_to_rule()
    {
        $product = new Product();
        $productVariant = new ProductVariant();
        $productVariant->setProduct($product);

        $productVariants = new ArrayCollection();
        $productVariants->add($productVariant);

        $rules = new ArrayCollection();
        $rule = new PromotionRule();
        $rule->setType('has_taxon');
        $rules->add($rule);

        $this->promotionEligibilityFilter->filter($productVariants, $rules);

        $this->assertEmpty($productVariants);
    }

    public function test_filter_case_eligible_to_rule()
    {
        $taxon = new Taxon();
        $taxon->setCode('my-taxon');

        $productTaxon = new ProductTaxon();
        $productTaxon->setTaxon($taxon);

        $product = new Product();
        $product->addProductTaxon($productTaxon);

        $productVariant = new ProductVariant();
        $productVariant->setProduct($product);

        $productVariants = new ArrayCollection();
        $productVariants->add($productVariant);

        $rule = new PromotionRule();
        $rule->setType('has_taxon');
        $rule->setConfiguration(['taxons' => ['my-taxon']]);

        $rules = new ArrayCollection();
        $rules->add($rule);

        $this->promotionEligibilityFilter->filter($productVariants, $rules);

        $this->assertNotEmpty($productVariants);
    }


}
