<?php

namespace App\Model;

use App\Entity\Task;

class Phpmd extends Task
{
    public const TOOL = 'phpmd';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'phpmd');
    }

    public function getDescription(): string
    {
        return 'Evaluate the quality of the source code';
    }

    public function getCommand(): string
    {
        return 'phpmd src xml "cleancode,codesize,controversial,design,naming,unusedcode"';
    }

    public function getGroup(): string
    {
        return 'Analysers';
    }
}