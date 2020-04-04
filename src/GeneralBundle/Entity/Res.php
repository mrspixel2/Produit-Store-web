<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Res
 *
 * @ORM\Table(name="res", indexes={@ORM\Index(name="id_velo", columns={"id_velo"})})
 * @ORM\Entity
 */
class Res
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     */
    private $idClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRes", type="datetime", nullable=false)
     */
    private $dateres;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=false)
     */
    private $datefin;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixTot", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixtot;

    /**
     * @var float
     *
     * @ORM\Column(name="HeureLoca", type="float", precision=10, scale=0, nullable=false)
     */
    private $heureloca;

    /**
     * @var \Velo
     *
     * @ORM\ManyToOne(targetEntity="Velo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_velo", referencedColumnName="id")
     * })
     */
    private $idVelo;


}

