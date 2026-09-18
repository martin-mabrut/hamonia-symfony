<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artiste;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('artist', EntityType::class, [
                'label' => 'Choississez un Artiste',
                'class' => Artiste::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('pochette', FileType::class, [
                'label' => 'Ajoutez une image de couverture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\File(
                        maxSize: '1900k',
                        extensions: ['jpg', 'jpeg', 'png'],
                        extensionsMessage: 'Formats attendus : JPG, JPEG, PNG',
                    )
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
