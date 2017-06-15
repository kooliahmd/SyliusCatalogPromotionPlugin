<?php
/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kooli\CatalogPromotion\Promotion\Applicator;

use Kooli\CatalogPromotion\Model\ChannelPricing;

class ChannelPricingPromotionApplicator
{
    public function apply(ChannelPricing $channelPricing, $promotionAmount)
    {
        $channelPricing->setPromotionAmount($channelPricing->getPromotionAmount() + $promotionAmount);
    }
}
