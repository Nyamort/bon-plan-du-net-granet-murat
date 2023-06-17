<?php

namespace App\Form;

use App\Entity\Alert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class AlertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('keyword', TextType::class, [
                'label' => 'Mot clé',
                'attr' => [
                    'placeholder' => 'Mot clé',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('minimum_notation', NumberType::class, [
                'label' => 'Note minimum',
                'attr' => [
                    'placeholder' => 'Note minimum',
                    'min' => 0,
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ],
                'html5' => true,
                'required' => true,
                'constraints' => [
                    new PositiveOrZero(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alert::class,
        ]);
    }
}
