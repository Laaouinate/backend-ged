<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImgRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert; 
use App\Controller\UploadImageAction;


/**
 * @ApiResource(
 *      attributes={"formats"={"json", "jsonld", "form"={"multipart/form-data"}}
 *                  },
 *      collectionOperations={
 *      "get",
 *      "post"={
 *          "method"="POST",
 *          "path"="/images",
 *          "controller"=UploadImageAction::class,
 *          "defaults" = {"_api_receive"=false}
 *             }
 *      }
 * )
 * @ORM\Entity(repositoryClass=ImgRepository::class)
 * @Vich\Uploadable()
 */
class Img
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="url")
     * @Assert\NotBlank()
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }
}
