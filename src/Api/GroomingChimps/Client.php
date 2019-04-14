<?php

namespace App\Api\GroomingChimps;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

class Client
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getJobs(): string
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            '/jobs',
            [
                'headers' => [
                    "accept" => "application/ld+json"
                ],
            ]
        );

        return $response->getContent();
    }

    public function createProject(string $repo, bool $isPrivate = false): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            '/projects',
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'repo' => $repo,
                    'isPrivate' => $isPrivate,
                ]
            ]
        );

        return $response->toArray();
    }

    public function createJob(string $project, string $branch): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            '/jobs',
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'project' => $project,
                    'branch' => $branch,
                ]
            ]
        );

        return $response->toArray();
    }

    public function createTasks(string $job, array $tasks): array
    {
        $responses = [];
        foreach ($tasks as $task) {
            $response = $this->httpClient->request(
                Request::METHOD_POST,
                '/tasks',
                [
                    'headers' => $this->getHeaders(),
                    'json' => [
                        'job' => $job,
                        'tool' => $task,
                    ]
                ]
            );

            $responses[] = $response->toArray();
        }

        return $responses;
    }

    private function getHeaders(): array
    {
        $headers = [
            "accept" => "application/ld+json",
            "content-type" => "application/ld+json",
        ];

        return array_merge($this->httpClient::OPTIONS_DEFAULTS['headers'], $headers);
    }
}
