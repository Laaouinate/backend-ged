<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numdecument;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $information;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="docs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Typedocument", mappedBy="archive")
     * 
     */
    private $tdocuments;

    public function __construct()
    {
        $this->tdocuments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumdecument(): ?string
    {
        return $this->numdecument;
    }

    public function setNumdecument(string $numdecument): self
    {
        $this->numdecument = $numdecument;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Typedocument[]
     */
    public function getTdocuments(): Collection
    {
        return $this->tdocuments;
    }

    public function addTdocument(Typedocument $tdocument): self
    {
        if (!$this->tdocuments->contains($tdocument)) {
            $this->tdocuments[] = $tdocument;
            $tdocument->setArchive($this);
        }

        return $this;
    }

    public function removeTdocument(Typedocument $tdocument): self
    {
        if ($this->tdocuments->contains($tdocument)) {
            $this->tdocuments->removeElement($tdocument);
            // set the owning side to null (unless already changed)
            if ($tdocument->getArchive() === $this) {
                $tdocument->setArchive(null);
            }
        }

        return $this;
    }

   


}