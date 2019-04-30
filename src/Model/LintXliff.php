<?php

namespace App\Model;

use App\Entity\Task;

class LintXliff extends Task
{
    public const TOOL = 'lint:xliff';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'Xliff');
    }

    public function getDescription(): string
    {
        return 'Validate Xliff templates';
    }

    public function getCommand(): string
    {
        return 'php bin/console lint:xliff --format=json translations';
    }

    public function getGroup(): string
    {
        return 'Linters';
    }
}