<?php

namespace App\Model;

use App\Entity\Task;

class PhpInsights extends Task
{
    public const TOOL = 'phpinsights';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'phpinsights');
        $this->setOptions([
            'cwd' => true,
        ]);
    }

    public function getDescription(): string
    {
        return 'Instant PHP quality checks from your console';
    }

    public function getCommand(): string
    {
        return 'phpinsights analyse -n --format=json src';
    }

    public function getGroup(): string
    {
        return 'Analysers';
    }
}
