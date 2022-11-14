<?php

namespace App\Entity;

use App\Model\TimestampedInterface;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit implements TimestampedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix_reduit = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marque = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_vendeur = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $contact_vendeur = null;

    #[ORM\Column]
    private ?bool $disponibilite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SousCategorie $sousCategorie = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaire;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Image::class, cascade: ["persist"], orphanRemoval: true)]
    private Collection $image;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: CommandeProduit::class, orphanRemoval: true)]
    private Collection $commande_produit;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Panier::class, orphanRemoval: true)]
    private Collection $panier;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Souhait::class, orphanRemoval: true)]
    private Collection $souhait;

    #[ORM\Column(length: 255)]
    private ?string $couverture_img = null;

    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->commande_produit = new ArrayCollection();
        $this->panier = new ArrayCollection();
        $this->souhait = new ArrayCollection();
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

    public function getPrixReduit(): ?float
    {
        return $this->prix_reduit;
    }

    public function setPrixReduit(?float $prix_reduit): self
    {
        $this->prix_reduit = $prix_reduit;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getNomVendeur(): ?string
    {
        return $this->nom_vendeur;
    }

    public function setNomVendeur(?string $nom_vendeur): self
    {
        $this->nom_vendeur = $nom_vendeur;

        return $this;
    }

    public function getContactVendeur(): ?string
    {
        return $this->contact_vendeur;
    }

    public function setContactVendeur(?string $contact_vendeur): self
    {
        $this->contact_vendeur = $contact_vendeur;

        return $this;
    }

    public function isDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setProduit($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProduit() === $this) {
                $commentaire->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduit(): Collection
    {
        return $this->commande_produit;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commande_produit->contains($commandeProduit)) {
            $this->commande_produit->add($commandeProduit);
            $commandeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commande_produit->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPanier(): Collection
    {
        return $this->panier;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->panier->contains($panier)) {
            $this->panier->add($panier);
            $panier->setProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->panier->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduit() === $this) {
                $panier->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Souhait>
     */
    public function getSouhait(): Collection
    {
        return $this->souhait;
    }

    public function addSouhait(Souhait $souhait): self
    {
        if (!$this->souhait->contains($souhait)) {
            $this->souhait->add($souhait);
            $souhait->setProduit($this);
        }

        return $this;
    }

    public function removeSouhait(Souhait $souhait): self
    {
        if ($this->souhait->removeElement($souhait)) {
            // set the owning side to null (unless already changed)
            if ($souhait->getProduit() === $this) {
                $souhait->setProduit(null);
            }
        }

        return $this;
    }

    public function getCouvertureImg(): ?string
    {
        return $this->couverture_img;
    }

    public function setCouvertureImg(string $couverture_img): self
    {
        $this->couverture_img = $couverture_img;

        return $this;
    }
}
