<?php

namespace App\Form\Type;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
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
                'help' => 'Veuillez donner le lien de la page où la communauté pourra profiter de votre annonce',
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez donner un lien valide'
                    ])
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => '5',
                    'class' => 'h-auto',
                    'preview'=> 'form-publication-description'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ]
            ])
            ->add('title', TextType::class,[
                'label' => 'Titre de la publication',
                'attr' => [
                    'placeholder' => 'Titre de la publication',
                    'preview'=> 'form-publication-title'
                ],
                'row_attr' => [
                    'class' => 'form-floating'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez donner un titre à votre publication'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                        'maxMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('image', DropzoneType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Déposez votre image ici',
                    'data-controller' => 'dropzone'
                ],
                'data_class' => null
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
