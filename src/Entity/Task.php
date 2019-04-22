<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task
{
    /**
     * @Assert\NotBlank()
     */
    private $tool;

    public function __construct(string $tool)
    {
        $this->tool = $tool;
    }

    public function getTool(): string
    {
        return $this->tool;
    }

    public function getCommand(): string
    {
        switch ($this->tool) {
            case 'lint:yaml':
                return 'php bin/console lint:twig --format=json config';
            case 'lint:xliff':
                return 'php bin/console lint:xliff --format=json translations';
            case 'lint:twig':
                return 'php bin/console lint:twig --format=json templates';
            case 'phpmd':
                return 'phpmd src xml "cleancode,codesize,controversial,design,naming,unusedcode"';
            default:
                return '';
        }
    }
}
