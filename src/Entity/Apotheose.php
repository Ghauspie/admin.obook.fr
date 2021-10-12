<?php

namespace App\Entity;

use App\Repository\ApotheoseRepository;
use App\Repository\UrlApotheoseRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ApotheoseRepository::class)
 */
class Apotheose
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
    private $promo;

    /**
     * @ORM\Column(type="text")
     */
    private $description;



    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_publish;

    /**
     * @ORM\OneToMany(targetEntity=UrlApotheose::class, mappedBy="apotheose")
     */
    private $urlapotheose;

    public function __construct()
    {
         $this->createdAt= new DateTime();
        $this->is_publish= false;
        $this->urlapotheose = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromo(): ?string
    {
        return $this->promo;
    }

    public function setPromo(string $promo): self
    {
        $this->promo = $promo;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsPublish(): ?bool
    {
        return $this->is_publish;
    }

    public function setIsPublish(bool $is_publish): self
    {
        $this->is_publish = $is_publish;

        return $this;
    }

    /**
     * @return Collection|UrlApotheose[]
     */
    public function getUrlapotheose(): Collection
    {
        return $this->urlapotheose;
    }

    public function getUrlapotheoses(): array
    {
        $urlList=[];
        foreach ($this->getUrlapotheose() as $url) {
            $urlList[]=[
               'url' => $url->getUrl(),
               'id'=>$url->getId()
            ]
            ;
        }
        return $urlList;
    }

    public function addUrlapotheose(UrlApotheose $urlapotheose): self
    {
        if (!$this->urlapotheose->contains($urlapotheose)) {
            $this->urlapotheose[] = $urlapotheose;
            $urlapotheose->setApotheose($this);
        }

        return $this;
    }

    public function removeUrlapotheose(UrlApotheose $urlapotheose): self
    {
        if ($this->urlapotheose->removeElement($urlapotheose)) {
            // set the owning side to null (unless already changed)
            if ($urlapotheose->getApotheose() === $this) {
                $urlapotheose->setApotheose(null);
            }
        }

        return $this;
    }



}
