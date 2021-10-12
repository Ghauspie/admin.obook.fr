<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Repository\TeamRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prod_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $git_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_apotheose;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtube_link;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="project")
     */
    private $teams;




    public function __construct()
    {
        $this->teams = new ArrayCollection();
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

    public function getProdLink(): ?string
    {
        return $this->prod_link;
    }

    public function setProdLink(string $prod_link): self
    {
        $this->prod_link = $prod_link;

        return $this;
    }

    public function getGitLink(): ?string
    {
        return $this->git_link;
    }

    public function setGitLink(?string $git_link): self
    {
        $this->git_link = $git_link;

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

    public function getIsApotheose(): ?bool
    {
        return $this->is_apotheose;
    }

    public function setIsApotheose(bool $is_apotheose): self
    {
        $this->is_apotheose = $is_apotheose;

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtube_link;
    }

    public function setYoutubeLink(?string $youtube_link): self
    {
        $this->youtube_link = $youtube_link;

        return $this;
    }

    //créer pour afficher la liste des user

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
            $team->setProject($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getProject() === $this) {
                $team->setProject(null);
            }
        }

        return $this;
    }
}
