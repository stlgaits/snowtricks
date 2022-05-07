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
        $imageFiles = scandir($imagesFolder);
        // remove the first 2 lines of the array which refer to '.' & '..'
        $parentDirs[0] = array_shift($imageFiles);
        $parentDirs[1] = array_shift($imageFiles);
        foreach ($imageFiles as $fileName) {
            $file = new File($fileName);
            if(is_file($file)){
                $this->fileUploader->loadFromOtherDir($file);
                $image = new Image();
                $image->setFileName($fileName)
                        ->setPath('/uploads/images/'.$image->getFileName())
                        ->setTrick($faker->randomElement($tricks))
                ;
                $manager->persist($image);
            } 
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TrickFixtures::class];
    }
}
