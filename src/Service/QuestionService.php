<?php


namespace App\Service;

use Github\Client;
use Symfony\Component\Yaml\Yaml;

class QuestionService
{
    private Client $client;

    private const GITHUB_USERNAME = 'certificationy';

    private const GITHUB_REPOSITORY = 'symfony-pack';

    private const GITHUB_BRANCH = 'master';

    private const GITHUB_DATA_PATH = 'data';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getFilesList(): array
    {
        return array_map(
            function ($file)
            {
                return [
                    'name' => $file['name'],
                    'path' => $file['path'],
                ];
            },
            $this->client->api('repo')->contents()->show(
                self::GITHUB_USERNAME,
                self::GITHUB_REPOSITORY,
                self::GITHUB_DATA_PATH,
                self::GITHUB_BRANCH,
            )
        );
    }

    public function getFileContent(string $filePath)
    {
        $fileContent = $this->client->api('repo')->contents()->download(
            self::GITHUB_USERNAME,
            self::GITHUB_REPOSITORY,
            $filePath,
            self::GITHUB_BRANCH,
        );

        return Yaml::parse($fileContent);
    }
}
