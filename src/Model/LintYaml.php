<?php

namespace App\Model;

use App\Entity\Task;

class LintYaml extends Task
{
    public const TOOL = 'lint:yaml';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'Yaml');
    }

    public function getDescription(): string
    {
        return 'Validate Yaml templates';
    }

    public function getCommand(): string
    {
        return 'php bin/console lint:yaml --format=json {{ path }}/config';
    }

    public function getGroup(): string
    {
        return 'Linters';
    }
}