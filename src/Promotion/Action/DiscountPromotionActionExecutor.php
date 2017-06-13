<?php

namespace Kooli\CatalogPromotion\Promotion\Action;

use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicatorInterface;

abstract class DiscountPromotionActionExecutor implements PromotionActionExecutorInterface
{
    /**
     * @var ChannelPricingPromotionApplicatorInterface
     */
    protected $promotionApplicator;

    /**
     * FixedDiscountPromotionActionCommand constructor.
     * @param ChannelPricingPromotionApplicatorInterface $promotionApplicator
     */
    public function __construct(ChannelPricingPromotionApplicatorInterface $promotionApplicator)
    {
        $this->promotionApplicator = $promotionApplicator;
    }

    /**
     * @param array $configuration
     */
    abstract protected function isConfigurationValid(array $configuration);


}
