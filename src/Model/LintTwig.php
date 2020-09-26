<?php

namespace App\Model;

use App\Entity\Task;

class LintTwig extends Task
{
    public const TOOL = 'lint:twig';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'Twig');
    }

    public function getDescription(): string
    {
        return 'Validate Twig templates';
    }

    public function getCommand(): string
    {
        return 'php bin/console lint:twig --format=json {{ path }}/templates';
    }

    public function getGroup(): string
    {
        return 'Linters';
    }
}
