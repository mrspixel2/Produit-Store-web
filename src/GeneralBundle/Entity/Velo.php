<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Velo
 *
 * @ORM\Table(name="velo", indexes={@ORM\Index(name="point_relais_id", columns={"id_point"}), @ORM\Index(name="id_point", columns={"id_point"})})
 * @ORM\Entity
 */
class Velo
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
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255, nullable=false)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="constructeur", type="string", length=255, nullable=false)
     */
    private $constructeur;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Pointlocation
     *
     * @ORM\ManyToOne(targetEntity="Pointlocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_point", referencedColumnName="id_point")
     * })
     */
    private $idPoint;


}

