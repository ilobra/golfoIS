<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iranga
 *
 * @ORM\Table(name="Iranga", indexes={@ORM\Index(name="tipas", columns={"tipas"})})
 * @ORM\Entity
 */
class Iranga
{
    /**
     * @var string
     *
     * @ORM\Column(name="kokybe", type="string", length=255, nullable=true)
     */
    private $kokybe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="isigijimo_data", type="date", nullable=false)
     */
    private $isigijimoData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\IrangosTipas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\IrangosTipas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipas", referencedColumnName="id_Irangos_tipas")
     * })
     */
    private $tipas;


}

