<?php

namespace App\Graph;

use App\Entity\Task;
use App\Factory\TaskFactory;

class TaskAggregator
{
    /** @var TaskFactory */
    private $factory;

    /** @var array */
    private $data;

    /** @var array */
    private $tasks;

    public function __construct(TaskFactory $factory, array $data)
    {
        $this->factory = $factory;
        $this->data = $data;
        $this->populateTasks();
    }

    public function getLabels(): array
    {
        return array_map(function (Task $task) {
            return $task->getTool();
        }, $this->tasks);
    }

    public function getErrors(): array
    {
        return array_map(function (Task $task) {
            return $task->getNumErrors();
        }, $this->tasks);
    }

    public function getTotalErrors(): int
    {
        return array_reduce($this->tasks, function ($errors, Task $task) {
            return $errors + $task->getNumErrors();
        }, 0);
    }

    private function populateTasks()
    {
        foreach ($this->data as $taskData) {
            /** @var Task $task */
            $task = $this->factory->createTask($taskData['tool']);
            $task->setGraph($taskData['graph']);
            $task->setOutput($taskData['output']);
            $task->setErrorOutput($taskData['errorOutput']);
            $task->setExitCode($taskData['exitCode']);

            $this->tasks[] = $task;
        }
    }
}
