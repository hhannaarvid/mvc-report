<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titel = null;

    #[ORM\Column]
    private ?int $ISBN = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $forfattare = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bild = null;

    #[ORM\Column(length: 255)]
    private ?string $bildnamn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): static
    {
        $this->titel = $titel;

        return $this;
    }

    public function getISBN(): ?int
    {
        return $this->ISBN;
    }

    public function setISBN(int $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getForfattare(): ?string
    {
        return $this->forfattare;
    }

    public function setForfattare(?string $forfattare): static
    {
        $this->forfattare = $forfattare;

        return $this;
    }

    public function getBild(): ?string
    {
        return $this->bild;
    }

    public function setBild(?string $bild): static
    {
        $this->bild = $bild;

        return $this;
    }

    public function getBildnamn(): ?string
    {
        return $this->bildnamn;
    }

    public function setBildnamn(?string $bildnamn): static
    {
        $this->bildnamn = $bildnamn;

        return $this;
    }
}
