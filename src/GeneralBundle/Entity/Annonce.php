<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="idC", columns={"idC"})})
 * @ORM\Entity
 */
class Annonce
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idA", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ida;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=50, nullable=false)
     */
    private $commentaire;

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

