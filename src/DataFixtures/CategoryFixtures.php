<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Service\SluggerService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = new SluggerService($slugger);
    }

    private $trickCategories = [
        'aerial',
        'flip',
        'grab',
        'inverted hand plants',
        'rotation',
        'slide',
        'spin',
        'stall',
        'straight air',
        'surface',
    ];

    public static function getReferenceKey($key): string
    {
        return sprintf('trick_category_%s', $key);
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->trickCategories as $key => $categoryName) {
            $category = new Category();
            $category->setName(ucfirst($categoryName));
            $category->setSlug($this->slugger->slugify($category->getName()));
            $manager->persist($category);
            $this->addReference(self::getReferenceKey($key), $category);
        }

        $manager->flush();
    }
}
