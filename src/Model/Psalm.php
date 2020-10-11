<?php

namespace App\Model;

use App\Entity\Task;

class Psalm extends Task
{
    public const TOOL = 'psalm';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'psalm');
        $this->setOptions([
            'cwd' => true,
        ]);
    }

    public function getDescription(): string
    {
        return 'A static analysis tool that attempts to dig into your program and find as many type-related bugs as possible';
    }

    public function getCommand(): string
    {
        return 'psalm --no-progress --ignore-baseline -m --output-format=json';
    }

    public function getGroup(): string
    {
        return 'Analysers';
    }
}
