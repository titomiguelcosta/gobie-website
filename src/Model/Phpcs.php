<?php

namespace App\Model;

use App\Entity\Task;

class Phpcs extends Task
{
    public const TOOL = 'phpcs';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'phpcs');
        $this->setOptions([
            'cwd' => true,
        ]);
    }

    public function getDescription(): string
    {
        return 'Detects violations of a defined coding standard.';
    }

    public function getCommand(): string
    {
        return 'phpcs --report=json src/';
    }

    public function getGroup(): string
    {
        return 'Analysers';
    }
}
