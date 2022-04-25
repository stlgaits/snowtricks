<?php

namespace App\Service\EmbedVideoLink;

class EmbedDailymotionUrlTrimmerService implements EmbedUrlTrimmerServiceInterface
{
    public function trimUrl(string $url): string
    {
        $url = $this->trimDailymotionUrl($url);

        return $url;
    }

    public function trimDailymotionUrl(string $url): string
    {
        return str_replace('https://www.dailymotion.com/video', 'https://www.dailymotion.com/embed/video', $url);
    }
}
