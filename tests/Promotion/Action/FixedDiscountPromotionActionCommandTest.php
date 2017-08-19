<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Tests\SnakeTn\CatalogPromotion\Promotion\Action;

use SnakeTn\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use SnakeTn\CatalogPromotion\Model\ProductVariant;
use SnakeTn\CatalogPromotion\Promotion\Action\FixedDiscountPromotionActionExecutor;
use PHPUnit\Framework\TestCase;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use SnakeTn\CatalogPromotion\Model\ChannelPricing;
use SnakeTn\CatalogPromotion\Entity\PromotionAction;

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

        $this->promotionAction = $this->createMock(PromotionAction::class);

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
