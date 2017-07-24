<?php

namespace SnakeTn\CatalogPromotion\Form\Type;

use Sylius\Bundle\PromotionBundle\Form\Type\Core\AbstractConfigurationCollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;


final class PromotionActionCollectionType extends AbstractConfigurationCollectionType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('entry_type', PromotionActionType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_promotion_action_collection';
    }
}
