<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

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
        $imageFiles = [];
        for ($i = 0; $i < $faker->randomNumber(2); ++$i) {
            $imageFiles[] = $faker->image('./public/uploads/images', 640, 480, fullPath:false);
        }
        foreach ($imageFiles as $imageFile) {
            $image = new Image();
            $image->setFileName($imageFile)
                    ->setPath('/uploads/images/'.$image->getFileName())
                    ->setTrick($faker->randomElement($tricks))
            ;
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TrickFixtures::class];
    }
}
