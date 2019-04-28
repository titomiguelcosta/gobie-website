<?php

namespace App\Factory;

use App\Entity\Task;

class LintTwig extends Task
{
    public function __construct()
    {
        parent::__construct('lint:twig', 'Twig');
    }

    public function getDescription(): string
    {
        return 'Validate Twig templates';
    }

    public function getCommand(): string
    {
        return 'php bin/console lint:twig --format=json templates';
    }

    public function getGroup(): string
    {
        return 'Linters';
    }
}