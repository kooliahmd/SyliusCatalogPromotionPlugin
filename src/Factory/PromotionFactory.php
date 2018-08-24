<?php

namespace SnakeTn\CatalogPromotion\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use SnakeTn\CatalogPromotion\Entity\Promotion;

/**
 * Class PromotionFactory
 */
class PromotionFactory implements FactoryInterface
{
    /**
     * @return object|Promotion
     */
    public function createNew()
    {
        return new Promotion();
    }
}
