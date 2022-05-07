<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\File;

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
            $file = new File($imagesFolder.'/'.$fileName);
            if (is_file($file)) {
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
