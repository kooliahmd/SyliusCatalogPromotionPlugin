<?php

namespace SnakeTn\CatalogPromotion\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

class ChannelPricing extends BaseChannelPricing implements PromotionSubjectInterface
{
    /**
     * @var ArrayCollection|\Sylius\Component\Core\Model\PromotionInterface[]
     */
    private $promotions;
    /**
     * @var int
     */
    private $promotionAmount = 0;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getPromotionAmount(): int
    {
        return $this->promotionAmount;
    }

    /**
     * @param int $promotionAmount
     */
    public function setPromotionAmount(int $promotionAmount)
    {
        $this->promotionAmount = $promotionAmount;
    }


    public function getPromotionSubjectTotal()
    {
        return $this->getPrice() - $this->getPromotionAmount();
    }

    public function getPromotions()
    {
        return $this->promotions;
    }

    public function hasPromotion(PromotionInterface $promotion)
    {
        return !$this->getPromotions()->isEmpty();
    }

    public function addPromotion(PromotionInterface $promotion)
    {
        $this->getPromotions()->add($promotion);
    }

    public function removePromotion(PromotionInterface $promotion)
    {
        // TODO: Implement removePromotion() method.
    }

}
