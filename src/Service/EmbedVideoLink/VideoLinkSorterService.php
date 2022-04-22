<?php 

namespace App\Service\EmbedVideoLink;

use Monolog\Logger;
use App\Service\EmbedVideoLink\EmbedUrlTrimmerServiceInterface;
use App\Service\EmbedVideoLink\EmbedDailymotionUrlTrimmerService;

class VideoLinkSorterService 
{
    private $urlTrimmerService;
    private $logger;

    public function __construct(EmbedUrlTrimmerServiceInterface $urlTrimmerService, Logger $logger)
    {
        $this->logger = $logger;
        $this->urlTrimmerService = $urlTrimmerService;
    }

    public function trimUrl(string $link): ?string
    {
        $this->assignUrlTrimmer($link);
        return $this->urlTrimmerService->trimUrl($link);
    }

    public function assignUrlTrimmer(string $link): void
    {
        switch ($link) {
            case str_contains($link, 'https://www.dailymotion.com/'):
                $this->urlTrimmerService = new EmbedDailymotionUrlTrimmerService();
                break;
            case str_contains($link, 'https://www.youtube.com/'):
                    $this->urlTrimmerService = new EmbedYoutubeUrlTrimmerService();
                break;
            default:
                $this->logger->error("Unsupported videolink submitted.");
                throw "Unsupported media platform";
                break;
        }
    }
}