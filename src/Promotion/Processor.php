<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SnakeTn\CatalogPromotion\Promotion;

use SnakeTn\CatalogPromotion\Model\ChannelPricing;
use SnakeTn\CatalogPromotion\Promotion\Action\ActionExecutorInterface;
use SnakeTn\CatalogPromotion\Promotion\Action\PercentageDiscountPromotionActionExecutor;
use SnakeTn\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicatorInterface;
use SnakeTn\CatalogPromotion\Promotion\Checker\Rule\RuleCheckerInterface;
use SnakeTn\CatalogPromotion\Repository\PromotionRepository;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use SnakeTn\CatalogPromotion\Entity\Promotion;
use Sylius\Component\Core\Repository\PromotionRepositoryInterface;
use SnakeTn\CatalogPromotion\Entity\PromotionRule;

class Processor
{
    /**
     * @var PromotionRepository
     */
    private $promotionRepository;

    /**
     * @var array|RuleCheckerInterface
     */
    private $ruleCheckers = [];
    /**
     * @var array|ActionExecutorInterface
     */
    private $actionExecutors = [];

    public function __construct(
        PromotionRepository $promotionRepository
    )
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function process(ProductVariantInterface $productVariant, ChannelInterface $channel)
    {
        if (!$productVariant->getChannelPricingForChannel($channel)) {
            return;
        }
        $channelPricing = new ChannelPricing();
        $channelPricing->setChannelCode($channel->getCode());
        $channelPricing->setPrice($productVariant->getChannelPricingForChannel($channel)->getPrice());

        foreach ($this->promotionRepository->findActiveByChannel($channel) as $promotion) {

            if ($promotion->isExclusive() && $this->isEligible($productVariant, $promotion)) {
                $this->apply($channelPricing, $promotion);
                return $channelPricing;
            }
        }

        foreach ($this->promotionRepository->findActiveByChannel($channel) as $promotion) {
            if ($this->isEligible($productVariant, $promotion)) {
                $this->apply($channelPricing, $promotion);
            }
        }

        return $channelPricing;
    }

    private function isEligible(ProductVariantInterface $productVariant, Promotion $promotion)
    {
        foreach ($promotion->getRules() as $rule) {
            if (!$this->isEligibleToRule($productVariant, $rule)) {
                return false;
            }
        }
        return true;
    }

    private function apply(ChannelPricing $channelPricing, Promotion $promotion)
    {
        foreach ($promotion->getActions() as $action) {
            $this->getActionExecutorByActionType($action->getType())->execute($channelPricing, $action);
        }
    }

    private function isEligibleToRule(ProductVariantInterface $productVariant, PromotionRule $rule)
    {
        /** @var RuleCheckerInterface $checker */
        $checker = $this->getRuleCheckerByRuleType($rule->getType());
        return $checker->isEligible($productVariant, $rule);
    }

    private function getRuleCheckerByRuleType($ruleType): RuleCheckerInterface
    {
        if (isset($this->ruleCheckers[$ruleType])) {
            return $this->ruleCheckers[$ruleType];
        }
        throw new \Exception(sprintf('rule type %s is not recognized.', $ruleType));
    }

    private function getActionExecutorByActionType($actionType): ActionExecutorInterface
    {
        if (isset($this->actionExecutors[$actionType])) {
            return $this->actionExecutors[$actionType];
        }
        throw new \Exception(sprintf('action type %s is not recognized.', $actionType));
    }

    public function addRuleChecker($ruleCheckerType, RuleCheckerInterface $ruleChecker)
    {
        $this->ruleCheckers[$ruleCheckerType] = $ruleChecker;
    }

    public function addActionExecutor($ruleActionType, ActionExecutorInterface $actionExecutor)
    {
        $this->actionExecutors[$ruleActionType] = $actionExecutor;
    }
}
