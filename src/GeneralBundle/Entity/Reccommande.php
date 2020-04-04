<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reccommande
 *
 * @ORM\Table(name="reccommande", indexes={@ORM\Index(name="idCll", columns={"idC"})})
 * @ORM\Entity
 */
class Reccommande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idRc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrc;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=50, nullable=false)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idC", referencedColumnName="idClient")
     * })
     */
    private $idc;


}

