<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SnakeTn\CatalogPromotion\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

class ChannelPricing extends BaseChannelPricing
{
    /** @var Collection|Promotion */
    private $promotions;

    /** @var int */
    private $promotionAmount = 0;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
    }

    public function getPromotionAmount(): int
    {
        return $this->promotionAmount;
    }

    public function setPromotionAmount(int $promotionAmount): void
    {
        $this->promotionAmount = $promotionAmount;
    }

    public function getPromotionSubjectTotal()
    {
        return $this->getPrice() - $this->getPromotionAmount();
    }
}
