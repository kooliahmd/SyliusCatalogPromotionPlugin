<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\SnakeTn\CatalogPromotion\Promotion\Checker\Rule;


use PHPUnit\Framework\TestCase;
use SnakeTn\CatalogPromotion\Entity\PromotionRule;
use SnakeTn\CatalogPromotion\Promotion\Checker\Rule\HasProductRuleChecker;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductVariant;

class HasProductRuleCheckerTest extends TestCase
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
        $product = new Product();
        $product->setCode('product_code');

        $this->productVariant = new ProductVariant();
        $this->productVariant->setProduct($product);

        $this->promotionRule = new PromotionRule();
    }

    public function test_case_eligible()
    {
        $hasProductRuleChecker = new HasProductRuleChecker();

        $this->promotionRule->setConfiguration(['product_codes' => ['product_code']]);

        $this->assertTrue($hasProductRuleChecker->isEligible($this->productVariant, $this->promotionRule));
    }

    public function test_case_not_eligible()
    {
        $hasProductRuleChecker = new HasProductRuleChecker();

        $this->promotionRule->setConfiguration(['product_codes' => ['unexistent_product_code']]);

        $this->assertFalse($hasProductRuleChecker->isEligible($this->productVariant, $this->promotionRule));
    }

}