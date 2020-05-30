<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Mapping\Annotation as EA;


/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * ORM\OneToMany(targetEntity="Marker", mappedBy="ville")
     */
    private $markers;

    /**
     * @ORM\OneToMany(targetEntity="Hotel", mappedBy="ville")
     */
    private $hotels;

    /**
     * @ORM\OneToMany(targetEntity="Activite", mappedBy="ville")
     */
    private $activites;

    /**
     * @ORM\OneToMany(targetEntity="Camping", mappedBy="ville")
     */
    private $campings;

    /**
     * @ORM\OneToMany(targetEntity="Resto", mappedBy="ville")
     */
    private $restos;

    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="villes")
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function __construct()
    {
        $this->hotels = new ArrayCollection();
        $this->activites = new ArrayCollection();
        $this->campings = new ArrayCollection();
        $this->restos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Hotel[]
     */
    public function getHotels(): Collection
    {
        return $this->hotels;
    }

    public function addHotel(Hotel $hotel): self
    {
        if (!$this->hotels->contains($hotel)) {
            $this->hotels[] = $hotel;
            $hotel->setVille($this);
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): self
    {
        if ($this->hotels->contains($hotel)) {
            $this->hotels->removeElement($hotel);
            // set the owning side to null (unless already changed)
            if ($hotel->getVille() === $this) {
                $hotel->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Activite[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setVille($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->contains($activite)) {
            $this->activites->removeElement($activite);
            // set the owning side to null (unless already changed)
            if ($activite->getVille() === $this) {
                $activite->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Camping[]
     */
    public function getCampings(): Collection
    {
        return $this->campings;
    }

    public function addCamping(Camping $camping): self
    {
        if (!$this->campings->contains($camping)) {
            $this->campings[] = $camping;
            $camping->setVille($this);
        }

        return $this;
    }

    public function removeCamping(Camping $camping): self
    {
        if ($this->campings->contains($camping)) {
            $this->campings->removeElement($camping);
            // set the owning side to null (unless already changed)
            if ($camping->getVille() === $this) {
                $camping->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resto[]
     */
    public function getRestos(): Collection
    {
        return $this->restos;
    }

    public function addResto(Resto $resto): self
    {
        if (!$this->restos->contains($resto)) {
            $this->restos[] = $resto;
            $resto->setVille($this);
        }

        return $this;
    }

    public function removeResto(Resto $resto): self
    {
        if ($this->restos->contains($resto)) {
            $this->restos->removeElement($resto);
            // set the owning side to null (unless already changed)
            if ($resto->getVille() === $this) {
                $resto->setVille(null);
            }
        }

        return $this;
    }


    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

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
}
