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

use Sylius\Component\Core\Calculator\ProductVariantPriceCalculatorInterface;
use Sylius\Component\Core\Exception\MissingChannelConfigurationException;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Webmozart\Assert\Assert;

class ProductVariantPriceCalculator implements ProductVariantPriceCalculatorInterface
{
    /**
     * @var Processor
     */
    private $promotionProcessor;

    public function __construct(Processor $promotionProcessor)
    {
        $this->promotionProcessor = $promotionProcessor;
    }

    public function calculate(ProductVariantInterface $productVariant, array $context)
    {
        Assert::keyExists($context, 'channel');

        $channelPricing = $this->promotionProcessor->process($productVariant, $context['channel']);


        if (null === $channelPricing) {
            throw new MissingChannelConfigurationException(sprintf(
                'Channel %s has no price defined for product variant %s',
                $context['channel']->getName(),
                $productVariant->getName()
            ));
        }

        return $channelPricing->getPromotionSubjectTotal();
    }

}
