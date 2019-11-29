<?php

declare(strict_types=1);

namespace App\Service;

class VideoDictionaryEditor
{
    /** @var string */
    private $repositoryPath;

    public function __construct(string $repositoryPath)
    {
        $this->repositoryPath = $repositoryPath;
    }

    public function addMediaToDictionary(string $fileName, $description)
    {
        $videosJsonPath         = $this->repositoryPath . '/assets/videos.json';
        $videosMetadataJsonPath = $this->repositoryPath . '/assets/videos_metadata.json';

        $jsonString = file_get_contents($videosJsonPath);

        $videos = json_decode($jsonString, true);

        array_unshift($videos, $fileName);

        $jsonMetadata = file_get_contents($videosMetadataJsonPath);

        $videosMetadata = json_decode($jsonMetadata, true);

        array_unshift(
            $videosMetadata,
            [
                'title' => $description,
                'file'  => $fileName,
            ]
        );

        $jsonString = json_encode($videos, JSON_PRETTY_PRINT);

        file_put_contents($videosJsonPath, $jsonString);

        $jsonMetadata = json_encode($videosMetadata, JSON_PRETTY_PRINT);
        file_put_contents($videosMetadataJsonPath, $jsonMetadata);
    }
}
