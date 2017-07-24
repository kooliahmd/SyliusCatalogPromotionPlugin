<?php

namespace SnakeTn\CatalogPromotion\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\PromotionBundle\Form\Type\AbstractConfigurablePromotionElementType;

final class PromotionActionType extends AbstractConfigurablePromotionElementType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('type', PromotionActionChoiceType::class, [
                'label' => 'sylius.form.promotion_rule.type',
                'attr' => [
                    'data-form-collection' => 'update',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_promotion_rule';
    }
}
