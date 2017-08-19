<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
