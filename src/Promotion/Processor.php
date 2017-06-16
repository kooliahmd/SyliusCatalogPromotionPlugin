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
     * @var PromotionRepositoryInterface
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

    /**
     * @param PromotionRepositoryInterface $promotionRepository
     */
    public function __construct(
        PromotionRepository $promotionRepository
    )
    {
        $this->promotionRepository = $promotionRepository;
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @param ChannelInterface $channel
     * @return ChannelPricing|null
     */
    public function process(ProductVariantInterface $productVariant, ChannelInterface $channel)
    {
        if (!$productVariant->getChannelPricingForChannel($channel)) {
            return;
        }
        $channelPricing = new ChannelPricing();
        $channelPricing->setChannelCode($channel->getCode());
        $channelPricing->setPrice($productVariant->getChannelPricingForChannel($channel)->getPrice());

        foreach ($this->promotionRepository->findActiveByChannel($channel) as $promotion) {

            if ($this->isEligible($productVariant, $promotion)) {
                $this->apply($channelPricing, $promotion);
            }
        }

        return $channelPricing;
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @param Promotion $promotion
     * @return bool
     */
    private function isEligible(ProductVariantInterface $productVariant, Promotion $promotion)
    {
        foreach ($promotion->getRules() as $rule) {
            if (!$this->isEligibleToRule($productVariant, $rule)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param ChannelPricing $channelPricing
     * @param Promotion $promotion
     */
    private function apply(ChannelPricing $channelPricing, Promotion $promotion)
    {
        foreach ($promotion->getActions() as $action) {
            $this->getActionExecutorByActionType($action->getType())->execute($channelPricing, $action);
        }
    }

    /**
     * @param ProductVariantInterface $productVariant
     * @param PromotionRule $rule
     * @return boolean
     */
    private function isEligibleToRule(ProductVariantInterface $productVariant, PromotionRule $rule)
    {
        /** @var RuleCheckerInterface $checker */
        $checker = $this->getRuleCheckerByRuleType($rule->getType());
        return $checker->isEligible($productVariant, $rule);
    }

    /**
     * @param $ruleType
     * @return RuleCheckerInterface
     * @throws \Exception
     */
    private function getRuleCheckerByRuleType($ruleType): RuleCheckerInterface
    {
        if (isset($this->ruleCheckers[$ruleType])) {
            return $this->ruleCheckers[$ruleType];
        }
        throw new \Exception(sprintf('rule type %s is not recognized.', $ruleType));
    }

    /**
     * @param $actionType
     * @return ActionExecutorInterface
     * @throws \Exception
     */
    private function getActionExecutorByActionType($actionType): ActionExecutorInterface
    {
        if (isset($this->actionExecutors[$actionType])) {
            return $this->actionExecutors[$actionType];
        }
        throw new \Exception(sprintf('action type %s is not recognized.', $actionType));
    }

    /**
     * @param $ruleCheckerType
     * @param RuleCheckerInterface $ruleChecker
     */
    public function addRuleChecker($ruleCheckerType, RuleCheckerInterface $ruleChecker)
    {
        $this->ruleCheckers[$ruleCheckerType] = $ruleChecker;
    }

    /**
     * @param $ruleActionType
     * @param ActionExecutorInterface $actionExecutor
     */
    public function addActionExecutor($ruleActionType, ActionExecutorInterface $actionExecutor)
    {
        $this->actionExecutors[$ruleActionType] = $actionExecutor;
    }


}
