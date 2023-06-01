<?php

namespace App\Form;

use App\Entity\CodePromo;
use App\Form\Type\PublicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodePromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class,[
                'label' => 'Code promo',
                'attr' => [
                    'placeholder' => 'Code promo',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('expiredAt', DateTimeType::class,[
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'label' => 'Date d\'expiration',
                'attr' => [
                    'placeholder' => 'Date d\'expiration',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('value', NumberType::class,[
                'label' => 'Valeur',
                'attr' => [
                    'placeholder' => 'Valeur',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('typeDeReduction', null, [
                'label' => 'Type de réduction',
                'attr' => [
                    'placeholder' => 'Type de réduction',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('publication', PublicationType::class, [
                'label' => false
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CodePromo::class
        ]);
    }
}
