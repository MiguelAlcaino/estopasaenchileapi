<?php

declare(strict_types=1);

namespace App\Service;

use Cocur\Slugify\Slugify;
use Cz\Git\GitRepository;
use Psr\Log\LoggerInterface;

class MediaCommiter
{
    /** @var LoggerInterface */
    private $logger;

    /** @var GitRepository */
    private $gitRepository;

    /** @var Slugify */
    private $slugify;

    /** @var string */
    private $repositoryPath;

    public function __construct(LoggerInterface $logger, GitRepository $gitRepository, Slugify $slugify, string $repositoryPath)
    {
        $this->logger         = $logger;
        $this->gitRepository  = $gitRepository;
        $this->slugify        = $slugify;
        $this->repositoryPath = $repositoryPath;
    }

    public function addAndCommitMedia(string $mediaUrl, string $description): void
    {
        $this->logger->debug('The name of the file received is:' . $mediaUrl);
        $this->logger->debug('Description: ' . $description);

        $filename = $this->repositoryPath . '/assets/videos/' . $this->slugify->slugify($description) . '.mp4';

        file_put_contents($filename, fopen($mediaUrl, 'rb'));

        $this->gitRepository->addFile($filename);
        $this->gitRepository->commit($description);
    }
}
