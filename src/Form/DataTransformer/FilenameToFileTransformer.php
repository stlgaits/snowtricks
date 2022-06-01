<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use App\Entity\Image;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;

class FilenameToFileTransformer implements DataTransformerInterface
{
    private $entityManager;
    private $fileUploader;

    public function __construct(EntityManagerInterface $entityManager, FileUploader $fileUploader)
    {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }

    /**
     * Transforms a string (filename) to an object (file).
     *
     * @param string $fileName
     *
     * @throws TransformationFailedException if object (file) is not found
     */
    public function transform($fileName): ?File
    {
        // no filename? It's optional, so that's ok
        if (!$fileName) {
            return null;
        }

        $image = $this->entityManager
            ->getRepository(Image::class)
            ->findOneBy(['fileName' => $fileName])
        ;
        if (null === $image) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf('A file with filename "%s" does not exist!', $fileName));
        }
        $imagesFolderPath = $this->fileUploader->getTargetDirectory();
        $file = new File($imagesFolderPath.'/'.$image->getFileName());

        return $file;
    }

    /**
     * Do not transform.
     *
     * @param File|null $file
     */
    public function reverseTransform($file): ?File
    {
        return $file;
    }
}
