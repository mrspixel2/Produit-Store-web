<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="idRe", columns={"idRe"})})
 * @ORM\Entity
 */
class Reclamation
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
     * @ORM\Column(name="contenu", type="string", length=100, nullable=false)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var \Recevent
     *
     * @ORM\ManyToOne(targetEntity="Recevent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRe", referencedColumnName="idR")
     * })
     */
    private $idre;


}

