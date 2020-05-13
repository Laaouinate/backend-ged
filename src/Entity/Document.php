<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ApiResource(
 * itemOperations={"GET"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *                 "normalization_context"={"groups"={"get-doc-with-user"}}     }
 *              ,"DELETE","PUT"={
 *      "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getUser()==user"
 * }
 * },
 * collectionOperations={"GET"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *          "normalization_context"={"groups"={"get-doc-with-user"}} }
 * ,"POST"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}},
 *      subresourceOperations={
 *  "api_users_docs_tdocuments_get_subresource"={"normalization_context"={"groups"={"get-doc-with-user"}}}
 *   
 *  
 * }
 * )
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
     * @Assert\NotBlank(message="champ numero document est obligatoire")
     * @Groups("get-doc-with-user")
     */
    private $numdecument;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="champ information est obligatoire")
     * @Groups("get-doc-with-user")
     */
    private $information;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("get-doc-with-user")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="docs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("get-doc-with-user")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Typedocument", mappedBy="archive")
     * @ApiSubresource()
     * @Groups("get-doc-with-user")
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
