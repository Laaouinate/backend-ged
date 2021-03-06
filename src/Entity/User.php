<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ApiResource(
 * itemOperations={
 * "GET"={
 *      "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *      "normalization_context"=
 *     {
 *      "groups"={"get"}
 *     }
 * }
 * ,"DELETE","PUT"={
 *          "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *          "denormalization_context"={
 *                                    "groups"={"put"}
 *                                    },
 *          "normalization_context"={"groups"={"get"}}
 *                 }},
 * collectionOperations={"GET"={
 *      "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"}
 * ,"POST"={"access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *       "denormalization_context"={
 *                                    "groups"={"post"}
 *                                  },
 *      "normalization_context"={"groups"={"get"}}
 * }}
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    const ROLE_AGENT = "ROLE_AGENT";
    const ROLE_EDITOR = "ROLE_EDITOR";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_SUPERADMIN = "ROLE_SUPERADMIN";

    const DEFAULT_ROLES=[self::ROLE_AGENT];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get","put","post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     * @Groups({"get","put","post","get-doc-with-user"})
     * @Assert\NotBlank(message="champ nom est obligatoire")
     * @Assert\Length(min=6, max=20, minMessage="ce champ doit avoir au moins {{ limit }} chars",maxMessage="ce champs ne doit pas dépasser {{ limit }} chars")
     * @Assert\Regex(pattern="/^[a-z]+$/i", message="le champ ne respecte pas le pattern")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=120)
     * @Groups({"get","put","post"})
     * @Assert\NotBlank(message="champ prenom est obligatoire")
     * @Assert\Length(min=6, max=20, minMessage="ce champ doit avoir au moins {{ limit }} chars",maxMessage="ce champs ne doit pas dépasser {{ limit }} chars")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=120)
     * @Groups({"get","post"})
     * @Assert\NotBlank(message="champ email est obligatoire")
     * @Assert\Email(message = "le email {{ value }} ne pas valider")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get","put","post"})
     * @Assert\NotBlank(message="champ fonction est obligatoire")
     */
    private $fonction;

    /**
     * @ORM\Column(type="string",length=150)
     * @Groups({"post","put"})
     * @Assert\NotBlank(message="champ password est obligatoire")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read","put","post"})
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"get","put","post","get-doc-with-user"})
     */
    private $serv;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="user")
     * @ApiSubresource()
     * @Groups({"get"})
     */
    private $docs;

    /**
     * @ORM\Column(type="simple_array", length=200, nullable=true)
     */
    private $roles;

    public function __construct()
    {
        $this->docs = new ArrayCollection();
        $this->roles = self::DEFAULT_ROLES;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

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

    public function getServ(): ?Departement
    {
        return $this->serv;
    }

    public function setServ(?Departement $serv): self
    {
        $this->serv = $serv;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocs(): Collection
    {
        return $this->docs;
    }

    public function addDoc(Document $doc): self
    {
        if (!$this->docs->contains($doc)) {
            $this->docs[] = $doc;
            $doc->setUser($this);
        }

        return $this;
    }

    public function removeDoc(Document $doc): self
    {
        if ($this->docs->contains($doc)) {
            $this->docs->removeElement($doc);
            // set the owning side to null (unless already changed)
            if ($doc->getUser() === $this) {
                $doc->setUser(null);
            }
        }

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

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // return $this->username;
    }
}
