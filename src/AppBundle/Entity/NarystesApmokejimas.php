<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NarystesApmokejimas
 *
 * @ORM\Table(name="Narystes_apmokejimas", indexes={@ORM\Index(name="VIP_narys_atlieka", columns={"fk_Narysid"})})
 * @ORM\Entity
 */
class NarystesApmokejimas
{
    /**
     * @var string
     *
     * @ORM\Column(name="suma", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $suma;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="narystes_pradzia", type="date", nullable=false)
     */
    private $narystesPradzia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="narystes_pabaiga", type="date", nullable=false)
     */
    private $narystesPabaiga;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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

