<?php

namespace App\Entity;

use App\Repository\CompilationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompilationRepository::class)
 */
class Compilation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $youtubeLinks = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $spotifyLinks = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length (max=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $private;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="likedCompilations")
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="compilations")
     */
    private $creator;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $pictures = [];

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="complilation")
     */
    private $comments;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYoutubeLinks(): ?array
    {
        return $this->youtubeLinks;
    }

    public function setYoutubeLinks(?array $youtubeLinks): self
    {
        $this->youtubeLinks = $youtubeLinks;

        return $this;
    }

    public function getSpotifyLinks(): ?array
    {
        return $this->spotifyLinks;
    }

    public function setSpotifyLinks(?array $spotifyLinks): self
    {
        $this->spotifyLinks = $spotifyLinks;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): self
    {
        $this->private = $private;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->addLikedCompilation($this);
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        if ($this->likes->removeElement($like)) {
            $like->removeLikedCompilation($this);
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getPictures(): ?array
    {
        return $this->pictures;
    }

    public function setPictures(?array $pictures): self
    {
        $this->pictures = $pictures;

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
            $comment->setComplilation($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getComplilation() === $this) {
                $comment->setComplilation(null);
            }
        }

        return $this;
    }
}
