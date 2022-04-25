<?php

namespace App\DataFixtures;

use App\Entity\Video;
use App\Repository\TrickRepository;
use App\Service\EmbedVideoLink\VideoLinkSorterService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    protected $trickRepository;
    protected $videoLinkTrimmer;

    private $videoLinks = [
        'butter' => [
            'https://www.youtube.com/watch?v=G9qlTInKbNE',
            'https://www.dailymotion.com/video/x18mekx',
        ],
        'indy grab' => [
            'https://www.youtube.com/watch?v=6yA3XqjTh_w',
            'https://www.youtube.com/watch?v=CA5bURVJ5zk',
            'https://www.dailymotion.com/video/x3xsj7',
        ],
        'japan' => [
            'https://www.youtube.com/watch?v=CzDjM7h_Fwo',
        ],
        'mute grab' => [
            'https://www.youtube.com/watch?v=CA5bURVJ5zk',
            'https://www.youtube.com/watch?v=51sQRIK-TEI',
        ],
        'nose grab' => [
            'https://www.youtube.com/watch?v=CA5bURVJ5zk',
            'https://www.dailymotion.com/video/x19pd',
        ],
        'ollie' => [
            'https://www.youtube.com/watch?v=AnI7qGQs0Ic',
            'https://www.youtube.com/watch?v=aAefkzI-zS0',
            'https://www.youtube.com/watch?v=kOyCsY4rBH0',
            'https://www.dailymotion.com/video/x5ggold',
        ],
        'sad' => [
            'https://www.youtube.com/watch?v=KEdFwJ4SWq4',
            'https://www.youtube.com/watch?v=NKHYEOAbFyM',
        ],
        'stalefish' => [
            'https://www.youtube.com/watch?v=f9FjhCt_w2U',
            'https://www.youtube.com/watch?v=CA5bURVJ5zk',
            'https://www.dailymotion.com/video/x3vpy',
        ],
        'tail grab' => [
            'https://www.youtube.com/watch?v=QMrelVooJR4',
            'https://www.youtube.com/watch?v=CA5bURVJ5zk',
        ],
        'wheelies' => [
            'https://www.youtube.com/watch?v=AKC80-zYU1c',
        ],
    ];

    public function __construct(TrickRepository $trickRepository, VideoLinkSorterService $videoLinkTrimmer)
    {
        $this->trickRepository = $trickRepository;
        $this->videoLinkTrimmer = $videoLinkTrimmer;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->videoLinks as $trickName => $videoLinksArray) {
            foreach ($videoLinksArray as $videoLink) {
                $trick = $this->trickRepository->findOneBy(['name' => ucfirst($trickName)]);
                $video = new Video();
                $videoLink = $this->videoLinkTrimmer->trimUrl($videoLink);
                $video->setLink($videoLink)
                    ->setTrick($trick);
                $manager->persist($video);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TrickFixtures::class];
    }
}
