<?php


namespace Kooli\CatalogPromotion\Promotion;


use Sylius\Component\Core\Calculator\ProductVariantPriceCalculatorInterface;
use Sylius\Component\Core\Exception\MissingChannelConfigurationException;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Webmozart\Assert\Assert;

class ProductVariantPriceCalculator implements ProductVariantPriceCalculatorInterface
{

    public function __construct(Processor $promotionProcessor)
    {
        $this->promotionProcessor = $promotionProcessor;
    }

    /**
     * {@inheritdoc}
     */
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
