<?php

namespace SnakeTn\CatalogPromotion\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Product\Model\ProductOptionValueInterface;
use Symfony\Component\Form\DataTransformerInterface;

class OptionValuesToCodesTransformer implements DataTransformerInterface
{

    public function __construct($optionValueRepository)
    {
        $this->optionValueRepository = $optionValueRepository;
    }

    public function transform($value)
    {
        $value = array ('mug_type_monster'

        );
        if (!is_array($value) && !is_null($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        if (empty($value)) {
            return new ArrayCollection();
        }

        return new ArrayCollection($this->optionValueRepository->findBy(['code' => $value]));
    }

    public function reverseTransform($productOptionValues)
    {
        return array_map(function (ProductOptionValueInterface $productOptionValue) {
            return $productOptionValue->getCode();
        }, $productOptionValues->toArray());
    }


}