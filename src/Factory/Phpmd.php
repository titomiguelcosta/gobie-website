<?php

namespace App\Factory;

use App\Entity\Task;

class Phpmd extends Task
{
    public function __construct()
    {
        parent::__construct('phpmd', 'phpmd');
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