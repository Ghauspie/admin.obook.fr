<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

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
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $story;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_search_job;

    /**
     * @var                     array
     * @ORM\Column(type="json")
     * @Ignore()
     */
    private $roles = [];

    /**
     * @var                       string The hashed password
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity=Techno::class, mappedBy="user")
     */
    private $technos;

    /**
     * @ORM\ManyToMany(targetEntity=Contrat::class, mappedBy="user")
     */
    private $contrats;

    /**
     * @ORM\ManyToOne(targetEntity=Spe::class, inversedBy="Users")
     */
    private $spe;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="user")
     */
    private $teams;

    public function __construct()
    {
        /* $this->roles = new ArrayCollection(); */
        $this->technos = new ArrayCollection();
        $this->contrats = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }
    
    public function jsonSerialize(): array
    {
        return [
            'roles'=> $this->roles,
        ];
    }

    /* public function __tostring()
    {
        $this->id;
        $this->technos;
        $this->firstname;
        $this->lastname;
        $this->email;
        $this->story;
        $this->roles;
        $this->FLname= $this->lastname.'  '.$this->firstname;
        $this->teams;
        $this->spe;

        #  return $this->getFLname() ?:'';  
    }
    */
    public function getFLname(): ?string
    {
        $FLname= $this->lastname .' '. $this->firstname;
        return $FLname;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getStory(): ?string
    {
        return $this->story;
    }

    public function setStory(?string $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getIsSearchJob(): ?bool
    {
        return $this->is_search_job;
    }

    public function setIsSearchJob(bool $is_search_job): self
    {
        $this->is_search_job = $is_search_job;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        /*     if (empty($roles)) {
            $roles[]='ROLE_USER';
        } ; */

        return array_unique($roles);
    }

  
    public function getRole(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
         //if (empty($roles)) {
          
        //} ;


        return array_unique($roles);
    }

    public function getRoles1(): ?array
    {
        $roles = $this->roles;

        return array($roles);
    }

    public function setRoles1(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setRoles($roles): array
    {
        $role=[];
        $role[]=$roles;
        /*       foreach($roles as $role){
            return $role;
        } */
        return $role;

    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }


    /**
     * @return Collection|Techno[]
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    public function getTechnoName(): ?string
    {
        return $this->technos->getName();
    }


    public function addTechno(Techno $techno): self
    {
        if (!$this->technos->contains($techno)) {
            $this->technos[] = $techno;
            $techno->addUser($this);
        }

        return $this;
    }

    public function getTechno(): array
    {
        $technoList=[];
        foreach ($this->getTechnos() as $techno) {
            $technoList[]=[
               'name' => $techno->getName(),
               'logo'=>$techno->getLogo(),
               'id'=>$techno->getId()
            ]
            ;
        }
        return $technoList;
    }

    public function removeTechno(Techno $techno): self
    {
        if ($this->technos->removeElement($techno)) {
            $techno->removeUser($this);
        }

        return $this;
    }




    /**
     * @return Collection|Contrat[]
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }
    public function getContrat(): array
    {
        $contratList=[];
        foreach ($this->getContrats() as $contrat) {
            $contratList[]=[
               'name' => $contrat->getName(),
               'id'=>$contrat->getId()
            ]
            ;
        }
        return $contratList;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->addUser($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            $contrat->removeUser($this);
        }

        return $this;
    }

    // 
    // SPE ############
    // 



    public function getSpeList(): array
    {
        $speList=[];
        $speList[]=[
            'id'=> $this->spe->getId(),
            'name'=>$this->spe->getName()
        ];

        return $speList;
    }

    public function getSpe(): ?Spe
    {
        return $this->spe;
    }

    public function setSpe(?Spe $spe): self
    {
        $this->spe = $spe;

        return $this;
    }

    public function getSpeName(): ?Spe
    {
        return $this->spe->getName();
    }

    // 
    // Partie Login##
    // 

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    ///**
    // * @see UserInterface
    // */
    /*     public function getRoles1(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles1(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    } */


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword1(): string
    {
        return $this->password;
    }

    public function setPassword1(string $password): self
    {
        $this->password = $password;

        return $this;
    } 

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setUser($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getUser() === $this) {
                $team->setUser(null);
            }
        }

        return $this;
    }
}
