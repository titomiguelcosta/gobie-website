<?php

namespace App\Model;

use App\Entity\Task;

class Phpstan extends Task
{
    public const TOOL = 'phpstan';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'phpstan');
        $this->setOptions([
            'cwd' => true
        ]);
    }

    public function getDescription(): string
    {
        return 'Finding errors without actually running it';
    }

    public function getCommand(): string
    {
        return 'phpstan analyse --no-progress -n -l 5 --error-format json src';
    }

    public function getGroup(): string
    {
        return 'Analysers';
    }
}