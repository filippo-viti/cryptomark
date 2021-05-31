<?php

namespace App\Entity;

use App\Repository\CpuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CpuRepository::class)
 */
class Cpu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $cores;

    /**
     * @ORM\Column(type="integer")
     */
    private $threads;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2)
     */
    private $clockSpeed;

    /**
     * @ORM\OneToMany(targetEntity=Benchmark::class, mappedBy="cpu", orphanRemoval=true)
     */
    private $benchmarks;

    public function __construct()
    {
        $this->benchmarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
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

    public function getCores(): ?int
    {
        return $this->cores;
    }

    public function setCores(int $cores): self
    {
        $this->cores = $cores;

        return $this;
    }

    public function getThreads(): ?int
    {
        return $this->threads;
    }

    public function setThreads(int $threads): self
    {
        $this->threads = $threads;

        return $this;
    }

    public function getClockSpeed(): ?string
    {
        return $this->clockSpeed;
    }

    public function setClockSpeed(string $clockSpeed): self
    {
        $this->clockSpeed = $clockSpeed;

        return $this;
    }

    /**
     * @return Collection|Benchmark[]
     */
    public function getBenchmarks(): Collection
    {
        return $this->benchmarks;
    }

    public function addBenchmark(Benchmark $benchmark): self
    {
        if (!$this->benchmarks->contains($benchmark)) {
            $this->benchmarks[] = $benchmark;
            $benchmark->setCpu($this);
        }

        return $this;
    }

    public function removeBenchmark(Benchmark $benchmark): self
    {
        if ($this->benchmarks->removeElement($benchmark)) {
            // set the owning side to null (unless already changed)
            if ($benchmark->getCpu() === $this) {
                $benchmark->setCpu(null);
            }
        }

        return $this;
    }
}
