<?php

namespace Kooli\CatalogPromotion\Promotion\Action;

use Sylius\Component\Promotion\Model\PromotionActionInterface;
use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

class FixedDiscountPromotionActionExecutor extends DiscountPromotionActionExecutor
{

    /**
     * @param array $configuration
     */
    protected function isConfigurationValid(array $configuration)
    {
        Assert::keyExists($configuration, 'amount');
        Assert::integer($configuration['amount']);
    }

    /**
     * @param PromotionSubjectInterface $subject
     * @param array $configuration
     * @param PromotionInterface $action
     * @return bool
     */
    public function execute(PromotionSubjectInterface $subject, PromotionActionInterface $action)
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
            $action->getConfiguration()[$subject->getChannelCode()]['amount']
        );

        $this->promotionApplicator->apply($subject, $promotionAmount);
    }

    /**
     * @param $promotionSubjectTotal
     * @param $targetPromotionAmount
     * @return mixed
     */
    private function calculatePromotionAmount($promotionSubjectTotal, $targetPromotionAmount)
    {
        return min($promotionSubjectTotal, $targetPromotionAmount);
    }

}
