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
 *      "access_control"=" is_granted('ROLE_EDITOR') or (is_granted('ROLE_AGENT') and object.getUser()==user)"
 * }
 * },
 * collectionOperations={"GET"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *          "normalization_context"={"groups"={"get-doc-with-user"}} }
 * ,"POST"={"access_control"="is_granted('ROLE_AGENT')"}},
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Typedocument", inversedBy="tdocuments")
     * @ORM\JoinColumn(nullable=true)
     * @Groups("get-doc-with-user")
     */
    private $archive;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Img")
     * @ORM\JoinColumn(name="img_id", referencedColumnName="id", nullable=true)
     * @Groups("get-doc-with-user")
     */
    private $img;


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

    public function getArchive(): ?Typedocument
    {
        return $this->archive;
    }

    public function setArchive(?Typedocument $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getImg(): ?Img
    {
        return $this->img;
    }

    public function setImg(?Img $img): self
    {
        $this->img = $img;

        return $this;
    }
}
