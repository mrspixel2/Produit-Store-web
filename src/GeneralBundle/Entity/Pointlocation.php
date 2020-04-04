<?php

namespace GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pointlocation
 *
 * @ORM\Table(name="pointlocation")
 * @ORM\Entity
 */
class Pointlocation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_point", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="Region", type="string", length=255, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="langitude", type="string", length=255, nullable=false)
     */
    private $langitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=false)
     */
    private $latitude;


}

