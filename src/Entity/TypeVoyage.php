<?php

namespace App\Entity;

use App\Repository\TypeVoyageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeVoyageRepository::class)
 */
class TypeVoyage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $typeVoyage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeVoyage(): ?string
    {
        return $this->typeVoyage;
    }

    public function setTypeVoyage(string $typeVoyage): self
    {
        $this->typeVoyage = $typeVoyage;

        return $this;
    }
}
