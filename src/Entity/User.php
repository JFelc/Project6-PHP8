<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\OneToOne(targetEntity=Token::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $Token;

    /**
     * @ORM\OneToMany(targetEntity=Figure::class, mappedBy="User")
     */
    private $Figure;

    /**
     * @ORM\OneToMany(targetEntity=Forum::class, mappedBy="User")
     */
    private $Forum;

        /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function __construct()
    {
        $this->Figure = new ArrayCollection();
        $this->Forum = new ArrayCollection();
    }

    public function get(): ?User 
    {
        $this->email = $this->getEmail();
        $this->username = $this->getUserIdentifier();
        $this->password = $this->getPassword();
        $this->id = $this->getId();

        return $this;
    }

    public function register($data): ?User
    {
        $this->setUsername($data['username']);
        $this->setPassword($data['password']);
        $this->setEmail($data['email']);

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getToken(): ?Token
    {
        return $this->Token;
    }

    public function setToken(?Token $Token): self
    {
        $this->Token = $Token;

        return $this;
    }

    /**
     * @return Collection|Figure[]
     */
    public function getFigure(): Collection
    {
        return $this->Figure;
    }

    public function addFigure(Figure $figure): self
    {
        if (!$this->Figure->contains($figure)) {
            $this->Figure[] = $figure;
            $figure->setUser($this);
        }

        return $this;
    }

    public function removeFigure(Figure $figure): self
    {
        if ($this->Figure->removeElement($figure)) {
            // set the owning side to null (unless already changed)
            if ($figure->getUser() === $this) {
                $figure->setUser(null);
            }
        }

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
            $forum->setUser($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->Forum->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getUser() === $this) {
                $forum->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // il est obligatoire d'avoir au moins un rôle si on est authentifié, par convention c'est ROLE_USER
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }
}
