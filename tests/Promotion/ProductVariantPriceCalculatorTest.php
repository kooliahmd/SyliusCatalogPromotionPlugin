<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\SnakeTn\CatalogPromotion;

use SnakeTn\CatalogPromotion\Promotion\Action\PercentageDiscountPromotionActionExecutor;
use SnakeTn\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use SnakeTn\CatalogPromotion\Promotion\Checker\Rule\HasProductRuleChecker;
use SnakeTn\CatalogPromotion\Promotion\Checker\Rule\HasTaxonRuleChecker;
use SnakeTn\CatalogPromotion\Promotion\Processor;
use SnakeTn\CatalogPromotion\Promotion\ProductVariantPriceCalculator;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelPricing;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductTaxon;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\Taxon;
use SnakeTn\CatalogPromotion\Repository\PromotionRepository;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use SnakeTn\CatalogPromotion\Entity\PromotionAction;
use SnakeTn\CatalogPromotion\Entity\PromotionRule;

class ProductVariantPriceCalculatorTest extends TestCase
{
    /**
     * @var ProductVariantPriceCalculator
     */
    private $productVariantPriceCalculator;
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $promotionRepository;

    public function setUp()
    {
        $this->promotionRepository = $this->createMock(PromotionRepository::class);
        $processor = new Processor($this->promotionRepository);
        $processor->addRuleChecker('has_taxon', new HasTaxonRuleChecker());
        $processor->addRuleChecker('has_product', new HasProductRuleChecker());
        $processor->addActionExecutor('product_variant_percentage_discount', new PercentageDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator()));

        $this->productVariantPriceCalculator = new ProductVariantPriceCalculator($processor);
    }

    public function test_process_case_eligible_to_one_promotion()
    {
        $productVariant = $this->getProductVariantHavingMyTaxon();
        $promotion = $this->getPromotion10PercentOnMyTaxon();

        $this->promotionRepository->method('findActiveByChannel')
            ->willReturn([$promotion]);

        $channel = new Channel();
        $channel->setCode('my-channel');

        $finalPrice = $this->productVariantPriceCalculator->calculate($productVariant, ['channel' => $channel]);
        $this->assertEquals(90, $finalPrice);

    }

    public function test_process_case_eligible_to_one_exclusive_promotion_and_one_non_exclusive_promotion()
    {
        $productVariant = $this->getProductVariantHavingMyTaxon();
        $productVariant->getProduct()->setCode('my-product');
        $this->promotionRepository->method('findActiveByChannel')
            ->willReturn([$this->getPromotion10PercentOnMyTaxon(),$this->getExclusivePromotion10PercentOnMyProduct()]);
        $channel = new Channel();
        $channel->setCode('my-channel');

        $finalPrice = $this->productVariantPriceCalculator->calculate($productVariant, ['channel' => $channel]);
        $this->assertEquals(90, $finalPrice);
    }

    /**
     * @return ProductVariant
     */
    private function getProductVariantHavingMyTaxon(): ProductVariant
    {
        $product = new Product();
        $productVariant = new ProductVariant();
        $productVariant->setProduct($product);
        $channelPricing = new ChannelPricing();
        $channelPricing->setPrice(100);
        $channelPricing->setChannelCode('my-channel');
        $productVariant->addChannelPricing($channelPricing);

        $taxon = new Taxon();
        $taxon->setCode('my-taxon');

        $productTaxon = new ProductTaxon();
        $productTaxon->setTaxon($taxon);

        $product->addProductTaxon($productTaxon);
        return $productVariant;
    }

    /**
     * @return Promotion
     */
    private function getPromotion10PercentOnMyTaxon(): Promotion
    {
        $rule = new PromotionRule();
        $rule->setType('has_taxon');
        $rule->setConfiguration(['taxons' => ['my-taxon']]);

        $action = new PromotionAction();
        $action->setType('product_variant_percentage_discount');
        $action->setConfiguration(['percentage' => 0.1]);

        $promotion = new Promotion();
        $promotion->addRule($rule);
        $promotion->addAction($action);
        return $promotion;
    }

    private function getExclusivePromotion10PercentOnMyProduct(): Promotion
    {
        $rule = new PromotionRule();
        $rule->setType('has_product');
        $rule->setConfiguration(['product_codes' => ['my-product']]);

        $action = new PromotionAction();
        $action->setType('product_variant_percentage_discount');
        $action->setConfiguration(['percentage' => 0.1]);

        $promotion = new Promotion();
        $promotion->addRule($rule);
        $promotion->addAction($action);
        $promotion->setExclusive(true);
        return $promotion;
    }
}
