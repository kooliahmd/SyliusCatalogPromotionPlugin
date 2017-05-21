<?php

namespace Tests\Kooli\CatalogPromotion\Promotion\Action;

use Kooli\CatalogPromotion\Promotion\Action\PercentageDiscountPromotionActionCommand;
use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use Kooli\CatalogPromotion\Model\ProductVariant;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Promotion;
use Kooli\CatalogPromotion\Model\ChannelPricing;
use Sylius\Component\Promotion\Model\PromotionAction;

class PercentageDiscountPromotionActionCommandTest extends TestCase
{
    /**
     * @var ChannelPricing
     */
    private $channelPricing;
    /**
     * @var PromotionAction
     */
    private $promotionAction;
    /**
     * @var Promotion
     */
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


    public function test_applied_promotion_case_percentage_less_than_100()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['channel_code' => ['percentage' => 0.30]]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(70, $this->channelPricing->getPromotionSubjectTotal());
    }


    public function test_applied_promotion_case_unvalid_configuration()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['channel_code' => ['percentage' => 'unvalid_config']]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_channel_not_configured()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionCommand(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->setConfiguration(['nonexistent_channel' => ['percentage' => 0.3]]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction->getConfiguration(), $this->promotion);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }


}
