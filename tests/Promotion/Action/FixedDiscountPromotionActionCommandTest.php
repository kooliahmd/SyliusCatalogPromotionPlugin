<?php

namespace Tests\Kooli\CatalogPromotion\Promotion\Action;

use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use Kooli\CatalogPromotion\Model\ProductVariant;
use Kooli\CatalogPromotion\Promotion\Action\FixedDiscountPromotionActionCommand;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Promotion;
use Kooli\CatalogPromotion\Model\ChannelPricing;
use Sylius\Component\Promotion\Model\PromotionAction;

class FixedDiscountPromotionActionCommandTest extends TestCase
{
    /**
     * @var ChannelPricing
     */
    private $channelPricing;
    /**
     * @var PromotionAction
     */
    private $promotionAction;
    private $promotion;


    public function setUp()
    {
        $this->channelPricing = new ChannelPricing();
        $this->channelPricing->setChannelCode('channel_code');

        $this->promotion = new Promotion();

        $this->promotionAction = new PromotionAction();

        $this->promotionAction->setPromotion($this->promotion);

        $this->promotion->addAction($this->promotionAction);
    }


    public function test_applied_promotion_case_amount_less_than_price()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['channel_code' => ['amount' => 10]]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(90, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_amount_grater_than_price()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['channel_code' => ['amount' => 9999]]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(0, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_unvalid_configuration()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['channel_code' => ['amount' => 'unvalid_config']]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_channel_not_configured()
    {
        $fixedDiscountPromotionActionCommand = new FixedDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['nonexistent_channel' => ['amount' => 10]]);

        $fixedDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }


}
