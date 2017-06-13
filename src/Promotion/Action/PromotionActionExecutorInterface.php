<?php
/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kooli\CatalogPromotion\Promotion\Action;


use Sylius\Component\Promotion\Model\PromotionActionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

interface PromotionActionExecutorInterface
{
    public function execute(PromotionSubjectInterface $subject, PromotionActionInterface $action);

}
