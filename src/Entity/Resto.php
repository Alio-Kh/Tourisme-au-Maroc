<?php

namespace App\Entity;

use App\Repository\RestoRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ville;

/**
 * @ORM\Entity(repositoryClass=RestoRepository::class)
 */
class Resto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // /**
    //  * @ORM\OneToOne(targetEntity=Marker::class)
    //  */
    // private $marker;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $imgPath;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="restos")
     */
    private $ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImgPath(): ?string
    {
        return $this->imgPath;
    }

    public function setImgPath(string $imgPath): self
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }

    // public function getMarker(): ?Marker
    // {
    //     return $this->marker;
    // }

    // public function setMarker(?Marker $marker): self
    // {
    //     $this->marker = $marker;

    //     return $this;
    // }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
