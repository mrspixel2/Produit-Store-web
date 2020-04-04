<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competition
 *
 * @ORM\Table(name="competition")
 * @ORM\Entity
 */
class Competition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="comp_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $compId;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=150, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="heure", type="string", length=20, nullable=false)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="circuit", type="string", length=20, nullable=false)
     */
    private $circuit;

    /**
     * @var integer
     *
     * @ORM\Column(name="long_circuit", type="integer", nullable=false)
     */
    private $longCircuit;

    /**
     * @var string
     *
     * @ORM\Column(name="organisateur", type="string", length=20, nullable=false)
     */
    private $organisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="recompense", type="string", length=50, nullable=false)
     */
    private $recompense;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_participant", type="integer", nullable=true)
     */
    private $nbrParticipant = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="max_participant", type="integer", nullable=false)
     */
    private $maxParticipant;


}

