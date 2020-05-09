<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Departement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\NotBlank(message="champ nom service est obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="serv")
     * 
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Typedocument", mappedBy="service")
     * 
     */
    private $Typedocs;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->Typedocs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setServ($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getServ() === $this) {
                $user->setServ(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Typedocument[]
     */
    public function getTypedocs(): Collection
    {
        return $this->Typedocs;
    }

    public function addTypedoc(Typedocument $typedoc): self
    {
        if (!$this->Typedocs->contains($typedoc)) {
            $this->Typedocs[] = $typedoc;
            $typedoc->setService($this);
        }

        return $this;
    }

    public function removeTypedoc(Typedocument $typedoc): self
    {
        if ($this->Typedocs->contains($typedoc)) {
            $this->Typedocs->removeElement($typedoc);
            // set the owning side to null (unless already changed)
            if ($typedoc->getService() === $this) {
                $typedoc->setService(null);
            }
        }

        return $this;
    }

}
