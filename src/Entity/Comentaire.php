<?php

namespace App\Entity;

use App\Repository\ComentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentaireRepository::class)
 */
class Comentaire
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
    private $comentaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentaire(): ?string
    {
        return $this->comentaire;
    }

    public function setComentaire(string $comentaire): self
    {
        $this->comentaire = $comentaire;

        return $this;
    }
}
