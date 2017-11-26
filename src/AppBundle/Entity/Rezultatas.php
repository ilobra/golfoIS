<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rezultatas
 *
 * @ORM\Table(name="Rezultatas", indexes={@ORM\Index(name="priklauso", columns={"fk_Aikstynasid"}), @ORM\Index(name="seka_ir_registruoja", columns={"fk_Narysid"})})
 * @ORM\Entity
 */
class Rezultatas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="raundas", type="integer", nullable=false)
     */
    private $raundas;

    /**
     * @var integer
     *
     * @ORM\Column(name="musimu_sk", type="integer", nullable=false)
     */
    private $musimuSk;

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

    /**
     * @var \AppBundle\Entity\Narys
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Narys")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Narysid", referencedColumnName="id")
     * })
     */
    private $fkNarysid;


}

