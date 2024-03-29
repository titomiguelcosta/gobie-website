<?php

namespace App\Factory;

use App\Entity\Task;
use App\Model\Churn;
use App\Model\LintTwig;
use App\Model\LintXliff;
use App\Model\LintYaml;
use App\Model\Phpcs;
use App\Model\PhpInsights;
use App\Model\Phploc;
use App\Model\Phpmd;
use App\Model\Phpstan;
use App\Model\Psalm;
use App\Model\SecurityCheck;

class TaskFactory
{
    private $map = [
        LintTwig::TOOL => LintTwig::class,
        LintYaml::TOOL => LintYaml::class,
        LintXliff::TOOL => LintXliff::class,
        Phpmd::TOOL => Phpmd::class,
        Phpstan::TOOL => Phpstan::class,
        Phploc::TOOL => Phploc::class,
        Phpcs::TOOL => Phpcs::class,
        SecurityCheck::TOOL => SecurityCheck::class,
        PhpInsights::TOOL => PhpInsights::class,
        Psalm::TOOL => Psalm::class,
        Churn::TOOL => Churn::class,
    ];

    private $tasks = [
        LintTwig::TOOL => null,
        LintXliff::TOOL => null,
        LintYaml::TOOL => null,
        Phpmd::TOOL => null,
        Phpstan::TOOL => null,
        Phploc::TOOL => null,
        Phpcs::TOOL => null,
        SecurityCheck::TOOL => null,
        PhpInsights::TOOL => null,
        Psalm::TOOL => null,
        Churn::TOOL => null,
    ];

    public function getTasks(): array
    {
        return [
            $this->createTask(LintYaml::TOOL),
            $this->createTask(LintXliff::TOOL),
            $this->createTask(LintTwig::TOOL),
            $this->createTask(Phpmd::TOOL),
            $this->createTask(Phpstan::TOOL),
            $this->createTask(Phpcs::TOOL),
            $this->createTask(SecurityCheck::TOOL),
            $this->createTask(PhpInsights::TOOL),
            $this->createTask(Psalm::TOOL),
            $this->createTask(Phploc::TOOL),
            $this->createTask(Churn::TOOL),
        ];
    }

    public function createTask(string $tool): Task
    {
        if (!array_key_exists($tool, $this->tasks)) {
            throw new \RuntimeException('No task definition');
        }

        if (null === $this->tasks[$tool]) {
            $this->tasks[$tool] = new $this->map[$tool]();
        }

        return $this->tasks[$tool];
    }
}
