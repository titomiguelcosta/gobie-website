<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobSubmitRepository")
 */
class JobSubmit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Url(protocols={"https"}, message="Only the https protocol is accepted.")
     */
    private $repo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $branch;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }

    public function getId(): ? int
    {
        return $this->id;
    }

    public function getName(): ? string
    {
        return $this->name;
    }

    public function setName(? string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRepo(): ? string
    {
        return $this->repo;
    }

    public function setRepo(string $repo): self
    {
        $this->repo = $repo;

        return $this;
    }

    public function getBranch(): ? string
    {
        return $this->branch;
    }

    public function setBranch(string $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function getUsername(): ? string
    {
        return $this->username;
    }

    public function setUsername(? string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getToken(): ? string
    {
        return $this->token;
    }

    public function setToken(? string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): ? \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
