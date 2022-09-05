<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: SousCategorie::class, orphanRemoval: true)]
    private Collection $souscatogorie;

    public function __construct()
    {
        $this->souscatogorie = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, SousCategorie>
     */
    public function getSouscatogorie(): Collection
    {
        return $this->souscatogorie;
    }

    public function addSouscatogorie(SousCategorie $souscatogorie): self
    {
        if (!$this->souscatogorie->contains($souscatogorie)) {
            $this->souscatogorie->add($souscatogorie);
            $souscatogorie->setCategorie($this);
        }

        return $this;
    }

    public function removeSouscatogorie(SousCategorie $souscatogorie): self
    {
        if ($this->souscatogorie->removeElement($souscatogorie)) {
            // set the owning side to null (unless already changed)
            if ($souscatogorie->getCategorie() === $this) {
                $souscatogorie->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
