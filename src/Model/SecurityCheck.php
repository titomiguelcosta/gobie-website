<?php

namespace App\Model;

use App\Entity\Task;

class SecurityCheck extends Task
{
    public const TOOL = 'security:check';

    public function __construct()
    {
        parent::__construct(self::TOOL, 'Security Check');
    }

    public function getDescription(): string
    {
        return 'Checks dependencies are being used with known security vulnerabilities';
    }

    public function getCommand(): string
    {
        return 'security-checker --format=json security:check';
    }

    public function getGroup(): string
    {
        return 'Security';
    }
}