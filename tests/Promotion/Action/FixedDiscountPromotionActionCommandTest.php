<?php

namespace Tests\Kooli\CatalogPromotion\Promotion\Action;

use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use Kooli\CatalogPromotion\Model\ProductVariant;
use Kooli\CatalogPromotion\Promotion\Action\FixedDiscountPromotionActionExecutor;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Promotion;
use Kooli\CatalogPromotion\Model\ChannelPricing;
use Sylius\Component\Promotion\Model\PromotionActionInterface;

class FixedDiscountPromotionActionCommandTest extends TestCase
{
    /**
     * @var ChannelPricing
     */
    private $channelPricing;
    /**
     * @var PromotionActionInterface
     */
    private $promotionAction;
    private $promotion;


    public function setUp()
    {
        $this->channelPricing = new ChannelPricing();
        $this->channelPricing->setChannelCode('channel_code');

        $this->promotion = new Promotion();

        $this->promotionAction = $this->createMock(PromotionActionInterface::class);

        $this->promotionAction->setPromotion($this->promotion);

        $this->promotion->addAction($this->promotionAction);
    }


    public function test_applied_promotion_case_amount_less_than_price()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['channel_code' => ['amount' => 10]]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(90, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_amount_grater_than_price()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['channel_code' => ['amount' => 9999]]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(0, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_unvalid_configuration()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['channel_code' => ['amount' => 'unvalid_config']]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_channel_not_configured()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['nonexistent_channel' => ['amount' => 10]]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }


}
