<?php

namespace App\Service\EmbedVideoLink;

use App\Service\EmbedVideoLink\EmbedUrlTrimmerServiceInterface;

class EmbedYoutubeUrlTrimmerService implements EmbedUrlTrimmerServiceInterface
{

    public function trimUrl(string $url): string
    {
        $url = $this->trimYoutubeUrl($url);
        return $url;
    }

    public function trimYoutubeUrl(string $url): string
    {
        return  str_replace("watch?v=", "embed/", $url);
    }

}
