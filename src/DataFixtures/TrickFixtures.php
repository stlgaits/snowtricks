<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Service\SluggerService;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    private $trickNames = [
        'butter',
        'indy grab',
        'japan',
        'mute grab',
        'nose grab',
        'ollie',
        'sad',
        'stalefish',
        'tail grab',
        'wheelies',
    ];

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = new SluggerService($slugger);
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        foreach ($this->trickNames as $key => $trickName) {
            $category = $this->getReference(CategoryFixtures::getReferenceKey($key % 10));
            $user = $this->getReference(UserFixtures::getReferenceKey($key % 10));
            $trick = new Trick();
            $trick->setName(ucfirst($trickName))
                ->setDescription($faker->text())
                ->setSlug($this->slugger->slugify($trick->getName()))
                ->setCreatedAt(new DateTimeImmutable('-1 day'))
                ->setUpdatedAt(new DateTimeImmutable())
                ->setCategory($category)
                ->setCreatedBy($user);
            $manager->persist($trick);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }
}
