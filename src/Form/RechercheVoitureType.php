<?php

namespace App\Form;

use App\Servive\RechercheVoiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RechercheVoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder  
            ->add('date_depart',DateType::class,[
            "widget" =>"single_text"
            ])

            ->add('date_retour',DateType::class,[
                "widget" =>"single_text"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'date_class' =>RechercheVoiture::class,
        ]);
    }
}
