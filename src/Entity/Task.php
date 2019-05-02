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

    protected $output;
    protected $errorOutput;
    protected $graph;
    protected $exitCode;

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

    public function getErrorOutput(): ?string
    {
        return $this->errorOutput;
    }

    public function setErrorOutput(string $errorOutput = null): self
    {
        $this->errorOutput = $errorOutput;

        return $this;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    public function setOutput(string $output = null): self
    {
        $this->output = $output;

        return $this;
    }

    public function getExitCode(): ?int
    {
        return $this->exitCode;
    }

    public function setExitCode(?int $exitCode): self
    {
        $this->exitCode = $exitCode ?? 0;

        return $this;
    }

    public function getGraph()
    {
        return $this->graph;
    }

    public function setGraph(array $data = []): self
    {
        $this->graph = $data;

        return $this;
    }

    public function getNumErrors()
    {
        return $this->graph['errors']['total'] ?? 0;
    }
}
