<?php

namespace SnakeTn\CatalogPromotion\Model;

use Doctrine\Common\Collections\ArrayCollection;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

class ChannelPricing extends BaseChannelPricing
{
    /**
     * @var ArrayCollection|Promotion
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


}
