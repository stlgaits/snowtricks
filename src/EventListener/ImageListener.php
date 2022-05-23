<?php

namespace App\EventListener;

use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;

class ImageListener
{
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Image) {
            return;
        }

        // We upload the file & set the path as path cannot be null
        $fileName = $entity->getFileName();
        $file = new File($fileName);
        if (is_file($file)) {
            $uniqueFileName = $this->fileUploader->loadFromOtherDir($file);
            $entity->setFileName($uniqueFileName)
                   ->setPath('/uploads/images/'.$entity->getFileName());
        }
    }
}
