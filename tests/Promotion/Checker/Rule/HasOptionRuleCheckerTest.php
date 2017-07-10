<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 7/6/17
 * Time: 4:46 PM
 */

namespace Tests\SnakeTn\CatalogPromotion\Promotion\Checker\Rule;


use PHPUnit\Framework\TestCase;
use SnakeTn\CatalogPromotion\Entity\PromotionRule;
use SnakeTn\CatalogPromotion\Promotion\Checker\Rule\HasOptionRuleChecker;
use Sylius\Component\Product\Model\ProductOption;
use Sylius\Component\Product\Model\ProductOptionValue;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductVariant;

class HasOptionRuleCheckerTest extends TestCase
{
    /**
     * @var ProductVariant
     */
    private $productVariant;
    /**
     * @var PromotionRule
     */
    private $promotionRule;

    public function setUp()
    {

        $productOption = new ProductOption();
        $this->productOptionValue = new ProductOptionValue();
        $this->productOptionValue->setOption($productOption);
        $this->productOptionValue->setCode('option_code');

        $product = new Product();
        $product->addOption($productOption);


        $this->productVariant = new ProductVariant();
        $this->productVariant->setProduct($product);
        $this->productVariant->addOptionValue($this->productOptionValue);

        $this->promotionRule = new PromotionRule();
    }

    public function test_case_eligible()
    {
        $this->promotionRule->setConfiguration(['option_values' => ['option_code']]);
        $hasOptionRuleChecker = new HasOptionRuleChecker();
        $this->assertTrue($hasOptionRuleChecker->isEligible($this->productVariant, $this->promotionRule));
    }

    public function test_case_not_eligible()
    {
        $this->promotionRule->setConfiguration(['option_values' => ['unexistent_option_code']]);
        $hasOptionRuleChecker = new HasOptionRuleChecker();
        $this->assertFalse($hasOptionRuleChecker->isEligible($this->productVariant, $this->promotionRule));
    }

    public function test_case_product_variant_not_attatched_to_any_option_value()
    {
        $this->promotionRule->setConfiguration(['option_values' => ['option_code']]);
        $hasOptionRuleChecker = new HasOptionRuleChecker();
        $this->productVariant->removeOptionValue($this->productOptionValue);
        $this->assertFalse($hasOptionRuleChecker->isEligible($this->productVariant, $this->promotionRule));

    }

}
