<?php

namespace SnakeTn\CatalogPromotion\Form\Type\Rule;

use SnakeTn\CatalogPromotion\Form\Type\OptionAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class HasOptionValueConfigurationType extends AbstractType
{
    private $dataTransformer;

    public function __construct(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('options', OptionAutocompleteChoiceType::class, [
                'label' => 'Option value',
                'multiple' => true,
            ]);
        $builder->get('options')->addModelTransformer($this->dataTransformer);

    }


}
