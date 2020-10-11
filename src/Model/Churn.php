<?php

namespace App\Model;

use App\Entity\Task;

class Churn extends Task
{
    public const TOOL = 'churn';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'churn');
        $this->setOptions([
            'cwd' => true,
        ]);
    }

    public function getDescription(): string
    {
        return 'Detects files that are good candidates for refactoring.';
    }

    public function getCommand(): string
    {
        return 'churn run src --format=json';
    }

    public function getGroup(): string
    {
        return 'Analysers';
    }
}
