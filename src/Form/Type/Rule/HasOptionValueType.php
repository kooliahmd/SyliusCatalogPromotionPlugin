<?php

namespace SnakeTn\CatalogPromotion\Form\Type\Rule;

use SnakeTn\CatalogPromotion\Form\Type\OptionAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HasOptionValueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('options', OptionAutocompleteChoiceType::class, [
                'label' => 'Option value',
                'multiple' => true,
            ]);

    }


}
