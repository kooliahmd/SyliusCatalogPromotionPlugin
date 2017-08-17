<?php

namespace SnakeTn\CatalogPromotion\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;

final class PromotionType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.form.promotion.name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'sylius.form.promotion.description',
                'required' => false,
            ])
            ->add('exclusive', CheckboxType::class, [
                'label' => 'sylius.form.promotion.exclusive',
            ])
            ->add('startsAt', DateTimeType::class, [
                'label' => 'sylius.form.promotion.starts_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('endsAt', DateTimeType::class, [
                'label' => 'sylius.form.promotion.ends_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('priority', IntegerType::class, [
                'label' => 'sylius.form.promotion.priority',
                'required' => false,
            ])
            ->add('rules', PromotionRuleCollectionType::class, [
                'label' => 'sylius.form.promotion.rules',
                'button_add_label' => 'sylius.form.promotion.add_rule',
            ])
            ->add('actions', PromotionActionCollectionType::class, [
                'label' => 'sylius.form.promotion.actions',
                'button_add_label' => 'sylius.form.promotion.add_action',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'sylius.form.promotion.channels',
            ])
            ->addEventSubscriber(new AddCodeFormSubscriber());

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_promotion';
    }
}
