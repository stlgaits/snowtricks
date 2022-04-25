<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Trick;
use App\Service\SluggerService;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = new SluggerService($slugger);
    }
    
    private $trickNames = [
        'mute', 
        'sad', 
        'indy', 
        'stalefish', 
        'tail grab', 
        'nose grab', 
        'ollie',
        'wheelies',
        'butter',
        'japan'

    ];

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        
        foreach($this->trickNames as $key => $trickName){
            $category = $this->getReference(CategoryFixtures::getReferenceKey($key % 10));
            $user = $this->getReference(UserFixtures::getReferenceKey($key %10));
            $trick = new Trick();
            $trick->setName(ucfirst($trickName));
            $trick->setDescription($faker->text());
            $trick->setSlug($this->slugger->slugify($trick->getName()));
            $trick->setCreatedAt(new DateTimeImmutable('-1 day'));
            $trick->setUpdatedAt(new DateTimeImmutable());
            $trick->addCategory($category);
            $trick->setCreatedBy($user);
            $manager->persist($trick);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ CategoryFixtures::class, UserFixtures::class];
    }
}
