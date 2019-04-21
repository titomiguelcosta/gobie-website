<?php

namespace App\Api\GroomingChimps;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;

class Client
{
    private $httpClient;
    private $security;

    public function __construct(HttpClientInterface $httpClient, Security $security)
    {
        $this->httpClient = $httpClient;
        $this->security = $security;
    }

    public function getUser(string $username): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            sprintf('/users/%s', $username),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function getToken(string $username, string $password): ?string
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            '/login_check',
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]
        );

        $data = $response->toArray();

        return $data['token'] ?? null;
    }

    public function getJobs(): string
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            '/jobs',
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->getContent();
    }

    public function createProject(string $repo, bool $isPrivate = false): array
    {
        $user = $this->security->getUser();
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            '/projects',
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'repo' => $repo,
                    'isPrivate' => $isPrivate,
                    'createdBy' => $user instanceof User ? $user->getId() : null,
                ],
                'auth_bearer' => $this->getAuthBearer(),
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
                ],
                'auth_bearer' => $this->getAuthBearer(),
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
                    ],
                    'auth_bearer' => $this->getAuthBearer(),
                ]
            );

            $responses[] = $response->toArray();
        }

        return $responses;
    }

    private function getHeaders(): array
    {
        $headers = [
            'accept' => 'application/ld+json',
            'content-type' => 'application/ld+json',
        ];

        return $headers;
    }

    private function getAuthBearer(): ?string
    {
        $user = $this->security->getUser();

        return $user instanceof User ? $user->getToken() : null;
    }
}
