<?php

namespace App\Model;

use App\Entity\Task;

class Phploc extends Task
{
    public const TOOL = 'phploc';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'phploc');
        $this->setOptions([
            'cwd' => true
        ]);
    }

    public function getDescription(): string
    {
        return 'Measure the size and analyzing the structure of a PHP project.';
    }

    public function getCommand(): string
    {
        return 'phploc --log-json=/dev/stdout -q src';
    }

    public function getGroup(): string
    {
        return 'Metrics';
    }
}
