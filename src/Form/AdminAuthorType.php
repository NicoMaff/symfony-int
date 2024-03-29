<?php

namespace App\Form;

use App\Entity\Author;
use PharIo\Manifest\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom :",
                "required" => true
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description :",
                "required" => false
            ])
            ->add('imageUrl', UrlType::class, [
                "label" => "Image de l'auteur :",
                "required" => false
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Valider",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
