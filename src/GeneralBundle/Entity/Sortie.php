<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sortie
 *
 * @ORM\Table(name="sortie")
 * @ORM\Entity
 */
class Sortie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sort_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sortId;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     */
    private $titre;

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
     * @var string
     *
     * @ORM\Column(name="organisateur", type="string", length=20, nullable=false)
     */
    private $organisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="guide", type="string", length=20, nullable=false)
     */
    private $guide;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_participant", type="integer", nullable=true)
     */
    private $nbrParticipant;


}

