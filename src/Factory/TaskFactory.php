<?php

namespace App\Factory;

use App\Entity\Task;
use App\Model\LintTwig;
use App\Model\LintXliff;
use App\Model\LintYaml;
use App\Model\Phpmd;
use App\Model\Phpstan;
use App\Model\SecurityCheck;
use App\Model\PhpInsights;
use RuntimeException;

class TaskFactory
{
    private $map = [
        LintTwig::TOOL => LintTwig::class,
        LintYaml::TOOL => LintYaml::class,
        LintXliff::TOOL => LintXliff::class,
        Phpmd::TOOL => Phpmd::class,
        Phpstan::TOOL => Phpstan::class,
        SecurityCheck::TOOL => SecurityCheck::class,
        PhpInsights::TOOL => PhpInsights::class,
    ];

    private $tasks = [
        LintTwig::TOOL => null,
        LintXliff::TOOL => null,
        LintYaml::TOOL => null,
        Phpmd::TOOL => null,
        Phpstan::TOOL => null,
        SecurityCheck::TOOL => null,
        PhpInsights::TOOL => null,
    ];

    /**
     * @return array
     */
    public function getTasks(): array
    {
        return [
            $this->createTask(LintYaml::TOOL),
            $this->createTask(LintXliff::TOOL),
            $this->createTask(LintTwig::TOOL),
            $this->createTask(Phpmd::TOOL),
            $this->createTask(Phpstan::TOOL),
            $this->createTask(SecurityCheck::TOOL),
            $this->createTask(PhpInsights::TOOL),
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
