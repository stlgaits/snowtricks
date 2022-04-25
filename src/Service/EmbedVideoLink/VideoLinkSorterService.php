<?php

namespace App\Service\EmbedVideoLink;

use Exception;
use Psr\Log\LoggerInterface;

class VideoLinkSorterService
{
    private $logger;

    public function __construct(
        LoggerInterface $logger
        ) {
        $this->logger = $logger;
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
                $this->logger->error('Unsupported videolink submitted.');
                // TODO: convert this exception into a flashmessage to the user with redirect
                throw new Exception('Unsupported media platform');
                break;
        }
    }
}
