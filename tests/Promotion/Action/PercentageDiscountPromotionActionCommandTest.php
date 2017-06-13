<?php

namespace Tests\Kooli\CatalogPromotion\Promotion\Action;

use Kooli\CatalogPromotion\Promotion\Action\PercentageDiscountPromotionActionExecutor;
use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use Kooli\CatalogPromotion\Model\ProductVariant;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\Promotion;
use Kooli\CatalogPromotion\Model\ChannelPricing;
use Sylius\Component\Promotion\Model\PromotionActionInterface;

class PercentageDiscountPromotionActionCommandTest extends TestCase
{
    /**
     * @var ChannelPricing
     */
    private $channelPricing;
    /**
     * @var PromotionActionInterface
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

        $this->promotionAction = $this->createMock(PromotionActionInterface::class);

        $this->promotionAction->setPromotion($this->promotion);

        $this->promotion->addAction($this->promotionAction);
    }


    public function test_applied_promotion_case_percentage_less_than_100()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['channel_code' => ['percentage' => 0.30]]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(70, $this->channelPricing->getPromotionSubjectTotal());
    }


    public function test_applied_promotion_case_unvalid_configuration()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['channel_code' => ['percentage' => 'unvalid_config']]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }

    public function test_applied_promotion_case_channel_not_configured()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['nonexistent_channel' => ['percentage' => 0.3]]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }


}
