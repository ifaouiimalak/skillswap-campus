<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, ['label' => 'Nom complet'])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio / Présentation',
                'required' => false,
                'attr' => ['rows' => 4],
            ])
            ->add('language', ChoiceType::class, [
                'label' => 'Langue',
                'choices' => ['Français' => 'Français', 'Anglais' => 'Anglais', 'Arabe' => 'Arabe'],
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'choices' => ['Débutant' => 'debutant', 'Intermédiaire' => 'intermediaire', 'Avancé' => 'avance'],
            ])
            ->add('avatarFile', FileType::class, [
                'label' => 'Photo de profil (JPEG, PNG, WebP - max 2 Mo)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
