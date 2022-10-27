<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locataire', TextType::class, ['label' => 'Nom du locataire'])
            ->add('gain', NumberType::class, ['label' => 'Montant des gains'])
            ->add('dateDebut', DateType::class, ['label' => 'Date de début', 'widget' => 'single_text',])
            ->add('dateFin', DateType::class, ['label' => 'Date de fin', 'widget' => 'single_text'])
            ->add('submit', SubmitType::class, ['label' => 'Créer la location '])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
