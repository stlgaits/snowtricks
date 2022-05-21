<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File as Fichier;

class ImageType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('fileName', FileType::class, [
                'label' => 'Image (.png or .jpg)',
                // unmapped means that this field is not associated to any entity property
                // 'mapped' => false,
                // 'multiple' => true,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                 // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG or JPG file',
                    ]),
                ],
            ]);
            // $builder->get('fileName')
            // ->addModelTransformer(new CallbackTransformer(
            //     function ($fileNameAsArray) {
            //         // transform the array to a string
            //         // return implode(', ', $fileNamesAsArray);
            //         $toto =  $fileNameAsArray;
            //         $path = "./assets/images/image_fixtures/";
            //         $tota =$path.$toto;
            //         return new Fichier($tota);
            //     }, 
            //     // function ($fileNamesAsArray) {
            //     //     // transform the array to a string
            //     //     return implode(', ', $fileNamesAsArray);
            //     // },
            //     function ($fileNamesAsString) {
            //         // transform the string back to an array
            //         return explode(', ', $fileNamesAsString);
            //     }
            // ))
        // ;
        // $builder->add('fileName', FileType::class);

        // $builder->get('fileName')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($tagsAsArray) {
        //             // dd($tagsAsArray);
        //             // $imagesFolder = realpath('/uploads/images/');
        //             // $imageFiles = scandir($imagesFolder);
        //             // // remove the first 2 lines of the array which refer to '.' & '..'
        //             // $parentDirs[0] = array_shift($imageFiles);
        //             // $parentDirs[1] = array_shift($imageFiles);
        //             // transform the array to a string
        //             // $toto = implode(', ', $tagsAsArray);
        //             // return new Fichier(realpath('./assets/images/image_fixtures/').$tagsAsArray);
        //             // return new Fichier("C:\Users\\estel\Desktop\Openclassrooms\P6_SnowTricks\snowtricks\public\uploads\images\09-042301-fitness-tips-for-snowboarding-627710a565c7e.jpg");
        //             return new Fichier("./uploads/images/09-042301-fitness-tips-for-snowboarding-627710a565c7e.jpg");
        //         },
        //         function ($tagsAsString) {
        //             // transform the string back to an array
        //             return new Fichier("./uploads/images/09-042301-fitness-tips-for-snowboarding-627710a565c7e.jpg");
        //             // return explode(', ', $tagsAsString);
        //         }
        //     ))
        // ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
