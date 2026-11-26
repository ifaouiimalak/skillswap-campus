<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Offer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('recipient', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'label' => 'Destinataire',
            ])
            ->add('offer', EntityType::class, [
                'class' => Offer::class,
                'choice_label' => 'title',
                'label' => 'Offre concernée (optionnel)',
                'required' => false,
                'placeholder' => '-- Aucune offre spécifique --',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => 3, 'placeholder' => 'Posez votre question avant la session...'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Message::class]);
    }
}
