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
                'label' => 'sylius.form.promotion_rule.has_option.options',
                'multiple' => true,
            ]);

    }


}
