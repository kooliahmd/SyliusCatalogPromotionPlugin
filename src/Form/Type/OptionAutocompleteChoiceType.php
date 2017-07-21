<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 7/10/17
 * Time: 4:39 PM
 */

namespace SnakeTn\CatalogPromotion\Form\Type;


use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;


class OptionAutocompleteChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'resource' => 'sylius.taxon',
            'choice_name' => 'code',
            'choice_value' => 'code',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['remote_criteria_type'] = 'contains';
        $view->vars['remote_criteria_name'] = 'phrase';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'catalog_promotion_option_autocomplete_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ResourceAutocompleteChoiceType::class;
    }
}
