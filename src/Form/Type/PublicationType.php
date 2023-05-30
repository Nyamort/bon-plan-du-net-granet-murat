<?php

namespace App\Form\Type;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', TextType::class,[
                'label' => 'Lien',
                'attr' => [
                    'placeholder' => 'Lien',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ],
                'help' => 'Veuillez donner le lien de la page où la communauté pourra profiter de votre annonce'
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => '5',
                    'class' => 'h-auto'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('title', TextType::class,[
                'label' => 'Titre de la publication',
                'attr' => [
                    'placeholder' => 'Titre de la publication',
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ]
            ])
            ->add('image', DropzoneType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Déposez votre image ici',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
