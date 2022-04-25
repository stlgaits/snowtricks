<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class SluggerService
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * Slugify a property's name (can then be used in URLs).
     */
    public function slugify(string $name): ?string
    {
        $slug = $this->slugger->slug($name, '-', 'en_GB');

        return $slug;
    }
}
