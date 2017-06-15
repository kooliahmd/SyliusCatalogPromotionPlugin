<?php
/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SnakeTn\CatalogPromotion\Promotion\Action;


use SnakeTn\CatalogPromotion\Model\ChannelPricing;
use Sylius\Component\Promotion\Model\PromotionActionInterface;

interface ActionExecutorInterface
{
    public function execute(ChannelPricing $subject, PromotionActionInterface $action);

}
