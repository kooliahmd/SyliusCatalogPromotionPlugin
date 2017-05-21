<?php

namespace Kooli\CatalogPromotion\Promotion\Action;

use Sylius\Component\Promotion\Action\PromotionActionCommandInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicatorInterface;

abstract class DiscountPromotionActionCommand implements PromotionActionCommandInterface
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

    public function revert(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
    }


}
