<?php

namespace App\Api\Gobie;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private $httpClient;
    private $security;

    public function __construct(HttpClientInterface $httpClient, Security $security)
    {
        $this->httpClient = $httpClient;
        $this->security = $security;
    }

    public function getUser(string $username, string $token = null): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            sprintf('/users/%s', $username),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $token ?? $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function auth(string $username, string $password): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            sprintf('/users/auth'),
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'username' => $username,
                    'password' => $password,
                ],
            ]
        );

        return $response->toArray();
    }

    public function getProjects(string $page = '1'): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            '/projects',
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
                'query' => [
                    'p' => $page,
                ],
            ]
        );

        return $response->toArray();
    }

    public function createProject(string $repo, string $description, bool $isPrivate = false): array
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            '/projects',
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'repo' => $repo,
                    'isPrivate' => $isPrivate,
                    'description' => $description,
                    'createdBy' => $user->getPath(),
                ],
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function deleteProject(int $id): bool
    {
        $response = $this->httpClient->request(
            Request::METHOD_DELETE,
            sprintf('/projects/%d', $id),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        try {
            $deleted = Response::HTTP_NO_CONTENT === $response->getStatusCode();
        } catch (ExceptionInterface $exception) {
            // ToDo: Log this exception
            $deleted = false;
        }

        return $deleted;
    }

    public function getJobs(): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            '/jobs',
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function getJob(int $id): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            sprintf('/jobs/%d', $id),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function createJob(string $project, string $branch, string $environment): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            '/jobs',
            [
                'headers' => $this->getHeaders(),
                'json' => [
                    'project' => $project,
                    'branch' => $branch,
                    'environment' => $environment,
                ],
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function rerunJob(string $jobId, string $jobToken): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_POST,
            sprintf('/jobs/%d/rerun?token=%s', $jobId, $jobToken),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        return $response->toArray();
    }

    public function deleteJob(int $id): bool
    {
        $response = $this->httpClient->request(
            Request::METHOD_DELETE,
            sprintf('/jobs/%d', $id),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        try {
            $deleted = Response::HTTP_NO_CONTENT === $response->getStatusCode();
        } catch (ExceptionInterface $exception) {
            // ToDo: Log this exception
            $deleted = false;
        }

        return $deleted;
    }

    public function createTasks(string $job, array $tasks): array
    {
        $responses = [];
        /** @var Task $task */
        foreach ($tasks as $task) {
            $response = $this->httpClient->request(
                Request::METHOD_POST,
                '/tasks',
                [
                    'headers' => $this->getHeaders(),
                    'json' => [
                        'job' => $job,
                        'tool' => $task->getTool(),
                        'command' => $task->getCommand(),
                        'options' => $task->getOptions(),
                    ],
                    'auth_bearer' => $this->getAuthBearer(),
                ]
            );

            $responses[] = $response->toArray();
        }

        return $responses;
    }

    public function deleteTask(int $id): bool
    {
        $response = $this->httpClient->request(
            Request::METHOD_DELETE,
            sprintf('/tasks/%d', $id),
            [
                'headers' => $this->getHeaders(),
                'auth_bearer' => $this->getAuthBearer(),
            ]
        );

        try {
            $deleted = Response::HTTP_NO_CONTENT === $response->getStatusCode();
        } catch (ExceptionInterface $exception) {
            // ToDo: Log this exception
            $deleted = false;
        }

        return $deleted;
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
