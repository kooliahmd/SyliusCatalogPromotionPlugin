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

use SnakeTn\CatalogPromotion\Promotion\Action\PercentageDiscountPromotionActionExecutor;
use SnakeTn\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicator;
use SnakeTn\CatalogPromotion\Model\ProductVariant;
use PHPUnit\Framework\TestCase;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use SnakeTn\CatalogPromotion\Model\ChannelPricing;
use SnakeTn\CatalogPromotion\Entity\PromotionAction;

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

        $this->promotionAction = $this->createMock(PromotionAction::class);

        $this->promotionAction->setPromotion($this->promotion);

        $this->promotion->addAction($this->promotionAction);
    }


    public function test_applied_promotion_case_percentage_less_than_100()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['percentage' => 0.30]);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(70, $this->channelPricing->getPromotionSubjectTotal());
    }


    public function test_applied_promotion_case_unvalid_configuration()
    {
        $percentageDiscountPromotionActionCommand = new PercentageDiscountPromotionActionExecutor(new ChannelPricingPromotionApplicator());
        $this->channelPricing->setPrice(100);
        $this->promotionAction->method('getConfiguration')->willReturn(['percentage' => 'unvalid_config']);

        $percentageDiscountPromotionActionCommand->execute($this->channelPricing, $this->promotionAction);

        $this->assertEquals(100, $this->channelPricing->getPromotionSubjectTotal());
    }

}
