<?php

namespace Kooli\CatalogPromotion\Promotion\Applicator;


use Kooli\CatalogPromotion\Model\ChannelPricing;

class ChannelPricingPromotionApplicator implements ChannelPricingPromotionApplicatorInterface
{
    public function apply(ChannelPricing $channelPricing, $promotionAmount)
    {
        $channelPricing->setPromotionAmount($channelPricing->getPromotionAmount() + $promotionAmount);
    }


}
