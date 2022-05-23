<?php

namespace App\EventListener;

use App\Entity\Video;
use App\Service\EmbedVideoLink\VideoLinkSorterService;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class VideoListener
{
    public function __construct(VideoLinkSorterService $videoLinkTrimmer)
    {
        $this->videoLinkTrimmer = $videoLinkTrimmer;
    }

    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Video) {
            return;
        }

        // In order to be displayed appropriately on the UI, we need to video link to be of type embed
        $link = $entity->getLink();
        $link = $this->videoLinkTrimmer->trimUrl($link);
        $entity->setLink($link);
    }
}
