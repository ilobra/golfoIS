<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Duobute
 *
 * @ORM\Table(name="Duobute", indexes={@ORM\Index(name="turi", columns={"fk_Aikstynasid"})})
 * @ORM\Entity
 */
class Duobute
{
    /**
     * @var string
     *
     * @ORM\Column(name="duobutes_info", type="string", length=255, nullable=false)
     */
    private $duobutesInfo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Aikstynas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aikstynas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Aikstynasid", referencedColumnName="id")
     * })
     */
    private $fkAikstynasid;


}

