<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TypedocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 * itemOperations={"GET"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}
 *                ,"DELETE",
 *                 "PUT"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}},
 * collectionOperations={"GET"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}
 *                      ,"POST"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}},
 * )
 * @ORM\Entity(repositoryClass=TypedocumentRepository::class)
 */
class Typedocument
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="champ description est obligatoire")
     * @Groups({"get-doc-with-user"})
     */
    private $descriptiontype;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document", inversedBy="tdocuments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $archive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="Typedocs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $service;

    public function __construct()
    {
        $this->Typedocs = new ArrayCollection();
        $this->tdocuments = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptiontype(): ?string
    {
        return $this->descriptiontype;
    }

    public function setDescriptiontype(string $descriptiontype): self
    {
        $this->descriptiontype = $descriptiontype;

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

    public function getService(): ?Departement
    {
        return $this->service;
    }

    public function setService(?Departement $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getArchive(): ?Document
    {
        return $this->archive;
    }

    public function setArchive(?Document $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

   
}
