<?php

namespace Kooli\CatalogPromotion\Promotion\Action;

use Sylius\Component\Promotion\Model\PromotionInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;
use Webmozart\Assert\Assert;

class PercentageDiscountPromotionActionCommand extends DiscountPromotionActionCommand
{
    protected function isConfigurationValid(array $configuration)
    {
        Assert::keyExists($configuration, 'percentage');
        Assert::float($configuration['percentage']);
    }

    public function execute(PromotionSubjectInterface $subject, array $configuration, PromotionInterface $promotion)
    {
        if (!isset($configuration[$subject->getChannelCode()])) {
            return false;
        }
        try {
            $this->isConfigurationValid($configuration[$subject->getChannelCode()]);
        } catch (\InvalidArgumentException $exception) {
            return false;
        }

        $promotionAmount = $this->calculatePromotionAmount(
            $subject->getPromotionSubjectTotal(),
            $configuration[$subject->getChannelCode()]['percentage']
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
