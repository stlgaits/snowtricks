<?php

namespace App\Service\EmbedVideoLink;

/**
 * Takes a video link's URL and trims it in order to transform it into an embeddable iframe URL.
 */
interface EmbedUrlTrimmerServiceInterface
{
    public function trimUrl(string $url): ?string;
}
