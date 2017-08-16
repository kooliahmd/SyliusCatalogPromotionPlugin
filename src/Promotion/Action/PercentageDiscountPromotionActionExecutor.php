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
use SnakeTn\CatalogPromotion\Entity\PromotionAction;
use Webmozart\Assert\Assert;

class PercentageDiscountPromotionActionExecutor extends DiscountPromotionActionExecutor
{
    /**
     * @param array $configuration
     */
    protected function isConfigurationValid(array $configuration)
    {
        Assert::keyExists($configuration, 'percentage');
        Assert::float($configuration['percentage']);
    }

    /**
     * @param ChannelPricing $subject
     * @param PromotionAction $action
     * @return bool
     */
    public function execute(ChannelPricing $subject, PromotionAction $action)
    {

        try {
            $this->isConfigurationValid($action->getConfiguration());
        } catch (\InvalidArgumentException $exception) {
            return false;
        }

        $promotionAmount = $this->calculatePromotionAmount(
            $subject->getPromotionSubjectTotal(),
            $action->getConfiguration()['percentage']
        );

        $this->promotionApplicator->apply($subject, $promotionAmount);
    }


    /**
     * @param $promotionSubjectTotal
     * @param $percentage
     * @return int
     */
    private function calculatePromotionAmount($promotionSubjectTotal, $percentage)
    {
        return (int)round($promotionSubjectTotal * $percentage);
    }

}
