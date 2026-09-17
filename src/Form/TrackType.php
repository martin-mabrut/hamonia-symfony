<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Playlist;
use App\Entity\Track;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('isSuitable')
            ->add('genres', EntityType::class, [
                'label' => 'Choisissez les genres qui correspondent à votre morceau :',
                'class' => Genre::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}
