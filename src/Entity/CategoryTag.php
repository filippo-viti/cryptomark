<?php

namespace App\Entity;

use App\Repository\CategoryTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryTagRepository::class)
 */
class CategoryTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="binary")
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity=Algorithm::class, mappedBy="tags")
     */
    private $algorithms;

    public function __construct()
    {
        $this->algorithms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Algorithm[]
     */
    public function getAlgorithms(): Collection
    {
        return $this->algorithms;
    }

    public function addAlgorithm(Algorithm $algorithm): self
    {
        if (!$this->algorithms->contains($algorithm)) {
            $this->algorithms[] = $algorithm;
            $algorithm->addTag($this);
        }

        return $this;
    }

    public function removeAlgorithm(Algorithm $algorithm): self
    {
        if ($this->algorithms->removeElement($algorithm)) {
            $algorithm->removeTag($this);
        }

        return $this;
    }
}