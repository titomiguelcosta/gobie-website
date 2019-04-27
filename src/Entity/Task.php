<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task
{
    /**
     * @Assert\NotBlank()
     */
    private $tool;
    private $label;

    public function __construct(string $tool, string $label)
    {
        $this->tool = $tool;
        $this->label = $label;
    }

    public function getTool(): string
    {
        return $this->tool;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getCommand(): string
    {
        return '';
    }

    public function getGroup(): string
    {
        return '';
    }

    public function getDescription(): string
    {
        return '';
    }
}
