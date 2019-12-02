<?php

declare(strict_types=1);

namespace App\Service;

use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;

class MediaCommiter
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Slugify */
    private $slugify;

    /** @var VideoDictionaryEditor */
    private $videoDictionaryEditor;

    /** @var int */
    private $fileNameLength;

    /** @var string */
    private $repositoryPath;

    public function __construct(
        LoggerInterface $logger,
        Slugify $slugify,
        VideoDictionaryEditor $videoDictionaryEditor,
        int $fileNameLength,
        string $repositoryPath
    ) {
        $this->logger                = $logger;
        $this->slugify               = $slugify;
        $this->videoDictionaryEditor = $videoDictionaryEditor;
        $this->fileNameLength        = $fileNameLength;
        $this->repositoryPath        = $repositoryPath;
    }

    public function addAndCommitMedia(string $mediaUrl, string $description): void
    {
        $this->logger->debug('The name of the file received is:' . $mediaUrl);
        $this->logger->debug('Description: ' . $description);

        $mediaFileName = substr($this->slugify->slugify($description), 0, $this->fileNameLength) . '.mp4';

        $filename = $this->repositoryPath . '/assets/videos/' . $mediaFileName;

        file_put_contents($filename, fopen($mediaUrl, 'rb'));

        $this->videoDictionaryEditor->addMediaToDictionary($mediaFileName, $description);
    }
}
