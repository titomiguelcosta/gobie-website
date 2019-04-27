<?php

namespace App\Factory;

use App\Entity\Task;
use RuntimeException;

class TaskFactory
{
    private $map = [
        'lint:twig' => LintTwig::class,
        'lint:yaml' => LintYaml::class,
        'lint:xliff' => LintXliff::class,
        'phpmd' => Phpmd::class,
    ];

    private $tasks = [
        'lint:twig' => null,
        'lint:xliff' => null,
        'lint:yaml' => null,
        'phpmd' => null,
    ];

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return [
            $this->createTask('lint:twig'),
            $this->createTask('lint:xliff'),
            $this->createTask('lint:yaml'),
            $this->createTask('phpmd'),
        ];
    }

    /**
     * @param string $tool
     * @return Task
     */
    public function createTask(string $tool): Task
    {
        if (!array_key_exists($tool, $this->tasks)) {
            throw new RuntimeException('No task definition');
        }

        if (null === $this->tasks[$tool]) {
            $this->tasks[$tool] = new $this->map[$tool]();
        }

        return $this->tasks[$tool];
    }
}