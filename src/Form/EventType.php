<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextType::class)
            ->add('price', MoneyType::class)
            // ->add('createdAt')
            ->add('startAt', null, [
                'years' => range(2021, 2031),
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd MMMM yyyy HH:mm',
            ])
            ->add('endAt', null, [
                'years' => range(2021, 2031),
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd MMMM yyyy HH:mm',
            ])
            ->add('posterUrl')
            ->add('posterFile', FileType::class)
            ->add('place', null, [
                'choice_label' => 'country',
                // 'expanded' => true, // radio à la place du select
            ])
            ->add('categories', null, [
                'choice_label' => 'name',
                'expanded' => true, // checkboxes à la place du select
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
