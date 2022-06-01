<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'name'])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'label' => false,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'label' => false,
                'allow_delete' => true,
                'entry_options' => ['label' => false],
                'by_reference' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'category',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-dark'],
                'label' => 'save',
                'row_attr' => ['class' => 'd-grid']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
