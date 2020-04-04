<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="idCc", columns={"idCc"}), @ORM\Index(name="idPro", columns={"idPro"})})
 * @ORM\Entity
 */
class Avis
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
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Evaluation", type="string", length=50, nullable=false)
     */
    private $evaluation;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPro", type="integer", nullable=false)
     */
    private $idpro;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCc", referencedColumnName="idClient")
     * })
     */
    private $idcc;


}

