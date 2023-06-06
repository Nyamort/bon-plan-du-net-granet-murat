<?php

namespace App\Form;

use App\Entity\Deal;
use App\Form\Type\PublicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price', NumberType::class,[
                'label' => 'Prix (€)',
                'attr' => [
                    'placeholder' => '0.00',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('regularPrice', NumberType::class,[
                'label' => 'Prix habituel (€)',
                'attr' => [
                    'placeholder' => '0.00',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            /*->add('expiredAt', DateTimeType::class,[
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'label' => 'Date d\'expiration',
                'attr' => [
                    'placeholder' => 'Date d\'expiration',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])*/
            ->add('fees', NumberType::class,[
                'label' => 'Frais de livraison (€)',
                'attr' => [
                    'placeholder' => '0.00',
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
            'data_class' => Deal::class,
        ]);
    }
}
