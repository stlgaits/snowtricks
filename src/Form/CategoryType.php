<?php

namespace App\Form;

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => Category::class,
                // 'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                // 'choice_label' => function ($category) {
                //     return $category->getName();
                // }
                // 'choices' => [

                // ],
                // // 'by_reference' => true,
                // // "name" is a property path, meaning Symfony will look for a public
                // // property or a public method like "getName()" to define the input
                // // string value that will be submitted by the form
                // 'choice_value' => 'name',
                // // a callback to return the label for a given choice
                // // if a placeholder is used, its empty value (null) may be passed but
                // // its label is defined by its own "placeholder" option
                // 'choice_label' => function(?Category $category) {
                //     return $category ? strtoupper($category->getName()) : '';
                // },
                // 'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
