<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Image;
use App\Service\FileUploader;
use App\Repository\TrickRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    protected $trickRepository;
    protected $fileUploader;

    public function __construct(TrickRepository $trickRepository, FileUploader $fileUploader)
    {
        $this->trickRepository = $trickRepository;
        $this->fileUploader = $fileUploader;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $tricks = $this->trickRepository->findAll();
        $imagesFolder = realpath('./assets/images/image_fixtures/');
        // $imagesFolder = pathinfo('./assets/images/image_fixtures/');
        $imageFiles = scandir($imagesFolder);
        $parentDirs[0] = array_shift($imageFiles);
        $parentDirs[1] = array_shift($imageFiles);
        // $imageFiles = array_shift($imageFiles);
        // var_dump($imageFiles);
        // die();
        // for ($i = 0; $i < $faker->randomNumber(2); ++$i) {
            // $imageFiles[] =  $this->fileUploader->upload($imageFile);
            // $imageFiles[] = $faker->image('./public/uploads/images', 640, 480, fullPath:false);
        // }
        foreach ($imageFiles as $key =>  $imageFile) {
            $filename = $key.'.jpg';
            $imageFile= strval($imagesFolder."\\".$imageFile);
            // $imageFile= pathinfo($imageFile)['filename'];
            $file = new UploadedFile($imageFile, $filename);
            if(is_file($file)){
                $this->fileUploader->upload($file);
                $image = new Image();
                $image->setFileName($imageFile)
                        ->setPath('/uploads/images/'.$image->getFileName())
                        ->setTrick($faker->randomElement($tricks))
                ;
                $manager->persist($image);
                echo PHP_EOL."OUI".PHP_EOL;
            } else {
                echo PHP_EOL."NON".PHP_EOL;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TrickFixtures::class];
    }
}
