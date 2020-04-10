<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use Symfony\Component\Validator\Constraints as Assert;
use SBC\NotificationsBundle\Model\NotifiableInterface;


/**
 * Produitbou
 *
 * @ORM\Table(name="produitbou")
 * @ORM\Entity(repositoryClass="GeneralBundle\Repository\ProduitbouRepository")
 */
class Produitbou implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="Prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="il faut ajouter l'image de votre produit")
     * @Assert\Image()
     * @ORM\Column(name="Image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="QteTotal", type="integer", nullable=false)
     */
    private $qtetotal;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commande", mappedBy="produit")
     */
    private $commande;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Panier", mappedBy="produit")
     */
    private $panier;

    /**
     * @var Store
     *
     * @ORM\ManyToOne(targetEntity="Store")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     * })
     */
    private $idStore;

    /**
     * @var string
     *
     * @ORM\Column(name="Categorie", type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commande = new \Doctrine\Common\Collections\ArrayCollection();
        $this->panier = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getQtetotal()
    {
        return $this->qtetotal;
    }

    /**
     * @param int $qtetotal
     */
    public function setQtetotal($qtetotal)
    {
        $this->qtetotal = $qtetotal;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $panier
     */
    public function setPanier($panier)
    {
        $this->panier = $panier;
    }

    /**
     * @return Store
     */
    public function getIdStore()
    {
        return $this->idStore;
    }

    /**
     * @param Store $idStore
     */
    public function setIdStore($idStore)
    {
        $this->idStore = $idStore;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle("New Product")
            ->setDescription($this->getNom())
            ->setRoute("produitbou_afficher")
            ->setParameters(array('id' => $this->getId()))
        ;

        $builder->addNotification($notification);
        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle("Update Product")
            ->setDescription($this->getNom())
            ->setRoute("produitbou_afficher")
            ->setParameters(array('id' => $this->getId()))
        ;

        $builder->addNotification($notification);
        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        return $builder;
    }


}

