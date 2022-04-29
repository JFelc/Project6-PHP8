<?php

namespace App\Entity;

use App\Repository\FigureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Photo;
use App\Entity\Groupe;

/**
 * @ORM\Entity(repositoryClass=FigureRepository::class)
 */
class Figure
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="figure", orphanRemoval=true)
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity=Videos::class, mappedBy="figure", orphanRemoval=true)
     */
    private $videos;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="figure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Groupe;

    /**
     * @ORM\OneToMany(targetEntity=Forum::class, mappedBy="Figure")
     */
    private $Forum;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Figure")
     */
    private $User;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->Forum = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setFigure($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getFigure() === $this) {
                dump($photo);
                $photo->setFigure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Videos[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Videos $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setFigure($this);
        }

        return $this;
    }

    public function removeVideo(Videos $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getFigure() === $this) {
                $video->setFigure(null);
            }
        }

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->Groupe;
    }

    public function setGroupe(?Groupe $Groupe): self
    {
        $this->Groupe = $Groupe;

        return $this;
    }

    /**
     * @return Collection|Forum[]
     */
    public function getForum(): Collection
    {
        return $this->Forum;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->Forum->contains($forum)) {
            $this->Forum[] = $forum;
            $forum->setFigure($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->Forum->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getFigure() === $this) {
                $forum->setFigure(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
