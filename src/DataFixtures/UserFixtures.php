<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class UserFixtures extends Fixture
{
    protected $hasher;
    private $params;

    public function __construct(UserPasswordHasherInterface $hasher, ContainerBagInterface $params)
    {
        $this->hasher = $hasher;
        $this->params = $params;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i< 15 ; $i++){
            $user = new User();
            $password = $faker->word();
            $user->setUsername($faker->userName())
                ->setEmail($faker->email())
                ->setPassword($this->hasher->hashPassword($user, $password))
                ->setIsVerified(true);
            $this->addReference(self::getReferenceKey($i), $user);
            $manager->persist($user);
        }

        // Create Super Admin User
        $admin = $this->addSuperAdmin();
        $manager->persist($admin);

        $manager->flush();
    }

    public function addSuperAdmin(): User
    {
        $admin = new User();
        $admin->setEmail($this->params->get('admin_email'))
            ->setUsername($this->params->get('admin_username'))
            ->setPassword($this->hasher->hashPassword($admin, $this->params->get('admin_password')))
            ->setIsVerified(true)
            ->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        return $admin;
    }

    public static function getReferenceKey($key)
    {
        return sprintf('user_%s', $key);
    }

}
