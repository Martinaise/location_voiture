<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('titre')
            ->add('marque')
            ->add('modele')
            ->add('description')
        // finetype pour creer un btn de chargementd'image  sur le formulaire
            ->add('photo',FileType::class,
            [

                "label"=> "charger une image",
                // pour enlévé l'obligation d'ajouter une photo
                "required" => false,
                "data_class" =>null
            ])
            
            ->add('prix_journalier')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
