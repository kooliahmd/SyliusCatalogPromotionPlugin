<?php

namespace Kooli\CatalogPromotion\Promotion\Action;

use Sylius\Component\Promotion\Model\PromotionActionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

class PercentageDiscountPromotionActionExecutor extends DiscountPromotionActionExecutor
{
    protected function isConfigurationValid(array $configuration)
    {
        Assert::keyExists($configuration, 'percentage');
        Assert::float($configuration['percentage']);
    }

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
