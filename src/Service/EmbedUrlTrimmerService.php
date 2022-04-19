<?php

namespace App\Service;

class EmbedUrlTrimmerService 
{

    public function trimUrl(string $url)
    {
        str_replace("https://www.youtube.com/watch?v=", "");;
    }
}