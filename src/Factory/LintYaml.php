<?php

namespace App\Factory;

use App\Entity\Task;

class LintYaml extends Task
{
    public function __construct()
    {
        parent::__construct('lint:yaml', 'Yaml');
    }

    public function getDescription(): string
    {
        return 'Validate Yaml templates';
    }

    public function getCommand(): string
    {
        return 'php bin/console lint:yaml --format=json config';
    }

    public function getGroup(): string
    {
        return 'Linters';
    }
}