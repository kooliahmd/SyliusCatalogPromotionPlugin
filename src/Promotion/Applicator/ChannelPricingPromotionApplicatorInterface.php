<?php

namespace Kooli\CatalogPromotion\Promotion\Applicator;

use Kooli\CatalogPromotion\Model\ChannelPricing;

interface ChannelPricingPromotionApplicatorInterface
{
    public function apply(ChannelPricing $channelPricing, $promotionAmount);

}
