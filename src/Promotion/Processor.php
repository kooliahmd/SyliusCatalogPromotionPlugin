<?php

/*
 * This file is part of Sylius catalog promotion plugin.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kooli\CatalogPromotion\Promotion;

use Kooli\CatalogPromotion\Promotion\Applicator\ChannelPricingPromotionApplicatorInterface;
use Kooli\CatalogPromotion\Promotion\Provider\ActivePromotionsProvider;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Core\Repository\PromotionRepositoryInterface;
use Sylius\Component\Promotion\Action\PromotionApplicatorInterface;

class Processor
{
    /**
     * @var PromotionRepositoryInterface
     */
    private $promotionRepository;
    /**
     * @var ProductVariantRepositoryInterface
     */
    private $productVariantRepository;

    /**
     * @var PromotionEligibilityFilter
     */
    private $promotionEligibilityFilter;

    /**
     * @var PromotionApplicatorInterface
     */
    private $promotionApplicator;

    /**
     * @param ActivePromotionsProvider $activePromotionsProvider
     * @param ProductVariantRepositoryInterface $productVariantRepository
     * @param PromotionEligibilityFilter $promotionEligibilityFilter
     * @param PromotionApplicatorInterface $promotionApplicator
     */
    public function __construct(
        PromotionRepositoryInterface $promotionRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        PromotionEligibilityFilter $promotionEligibilityFilter,
        ChannelPricingPromotionApplicatorInterface $promotionApplicator
    )
    {
        $this->promotionRepository = $promotionRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->promotionEligibilityFilter = $promotionEligibilityFilter;
        $this->promotionApplicator = $promotionApplicator;
    }

    public function process()
    {
        foreach ($this->promotionRepository->findActive() as $promotion) {
            $productVariants = $this->productVariantRepository->findAll();
            $this->promotionEligibilityFilter->filter($productVariants, $promotion->getRules());
        }
    }


}
