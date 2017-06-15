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
     * @param PromotionActionInterface $action
     * @return bool
     */
    public function execute(ChannelPricing $subject, PromotionActionInterface $action)
    {
        if (!isset($action->getConfiguration()[$subject->getChannelCode()])) {
            return false;
        }
        try {
            $this->isConfigurationValid($action->getConfiguration()[$subject->getChannelCode()]);
        } catch (\InvalidArgumentException $exception) {
            return false;
        }

        $promotionAmount = $this->calculatePromotionAmount(
            $subject->getPromotionSubjectTotal(),
            $action->getConfiguration()[$subject->getChannelCode()]['percentage']
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
