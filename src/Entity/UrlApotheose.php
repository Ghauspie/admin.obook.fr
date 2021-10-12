<?php

namespace App\Entity;

use App\Repository\UrlApotheoseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlApotheoseRepository::class)
 */
class UrlApotheose
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Apotheose::class, inversedBy="urlapotheose")
     */
    private $apotheose;

 

    public function __construct()
    {
        $this->apotheoses = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getApotheose(): ?Apotheose
    {
        return $this->apotheose;
    }

    public function setApotheose(?Apotheose $apotheose): self
    {
        $this->apotheose = $apotheose;

        return $this;
    }

 


}
