<?php


namespace App\Entity;

use App\Repository\BenchmarkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BenchmarkRepository::class)
 */
class Benchmark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $score;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Algorithm::class, inversedBy="benchmarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $algorithm;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="benchmarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Cpu::class, inversedBy="benchmarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cpu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAlgorithm(): ?Algorithm
    {
        return $this->algorithm;
    }

    public function setAlgorithm(?Algorithm $algorithm): self
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCpu(): ?Cpu
    {
        return $this->cpu;
    }

    public function setCpu(?Cpu $cpu): self
    {
        $this->cpu = $cpu;

        return $this;
    }
}