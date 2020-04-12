<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="GeneralBundle\Repository\RatingRepository")
 */
class Rating
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="rat", type="integer")
     */
    private $rat;

    /**
     * @ORM\ManyToOne(targetEntity="GeneralBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="GeneralBundle\Entity\Produitbou")
     * @ORM\JoinColumn(name="id_produit",referencedColumnName="id")
     */
    private $produitbou;

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
     * @return int
     */
    public function getRat()
    {
        return $this->rat;
    }

    /**
     * @param int $rat
     */
    public function setRat($rat)
    {
        $this->rat = $rat;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProduitbou()
    {
        return $this->produitbou;
    }

    /**
     * @param mixed $produitbou
     */
    public function setProduitbou($produitbou)
    {
        $this->produitbou = $produitbou;
    }


}

