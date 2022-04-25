<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    protected $trickRepository;
    protected $userRepository;

    public function __construct(TrickRepository $trickRepository, UserRepository $userRepository)
    {
        $this->trickRepository = $trickRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $tricks = $this->trickRepository->findAll();
        $users = $this->userRepository->findAll();
        foreach ($tricks as $trick) {
            for ($i = 0; $i < $faker->randomNumber(2); ++$i) {
                $comment = new Comment();
                $fakeDateTime = $faker->dateTimeBetween($trick->getCreatedAt());
                $fakeDateTimeImmutable = DateTimeImmutable::createFromMutable($fakeDateTime);
                $comment->setMessage($faker->paragraph())
                        ->setAuthor($faker->randomElement($users))
                        ->setCreatedAt($fakeDateTimeImmutable)
                        ->setTrick($trick)
                ;
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TrickFixtures::class, UserFixtures::class];
    }
}
