<?php


namespace App\Entity;

use App\Repository\AlgorithmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AlgorithmRepository::class)
 */
class Algorithm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"byCategoryGroup"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $creator;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $keyLength;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $digestSize;

    /**
     * @ORM\OneToMany(targetEntity=Benchmark::class, mappedBy="algorithm", orphanRemoval=true)
     */
    private $benchmarks;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"byCategoryGroup"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=CategoryTag::class, inversedBy="algorithms", cascade={"persist"})
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="algorithm", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->benchmarks = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(?string $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

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
            $benchmark->setAlgorithm($this);
        }

        return $this;
    }

    public function removeBenchmark(Benchmark $benchmark): self
    {
        if ($this->benchmarks->removeElement($benchmark)) {
            // set the owning side to null (unless already changed)
            if ($benchmark->getAlgorithm() === $this) {
                $benchmark->setAlgorithm(null);
            }
        }

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

    public function getKeyLength(): ?int
    {
        return $this->keyLength;
    }

    public function setKeyLength(int $keyLength): self
    {
        $this->keyLength = $keyLength;

        return $this;
    }

    public function getDigestSize(): ?int
    {
        return $this->digestSize;
    }

    public function setDigestSize(int $digestSize): self
    {
        $this->digestSize = $digestSize;

        return $this;
    }

    /**
     * @return Collection|CategoryTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(CategoryTag $tag): self
    {
        $tag->addAlgorithm($this);
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(CategoryTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAlgorithm($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAlgorithm() === $this) {
                $comment->setAlgorithm(null);
            }
        }

        return $this;
    }
}