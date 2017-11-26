<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IrangosApmokejimas
 *
 * @ORM\Table(name="Irangos_apmokejimas", indexes={@ORM\Index(name="atlieka", columns={"fk_Narysid"}), @ORM\Index(name="apmokama", columns={"fk_Irangaid"})})
 * @ORM\Entity
 */
class IrangosApmokejimas
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
     * @ORM\Column(name="isnuomojimo_pradzia", type="date", nullable=false)
     */
    private $isnuomojimoPradzia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="isnuomojimo_pabaiga", type="date", nullable=false)
     */
    private $isnuomojimoPabaiga;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Iranga
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Iranga")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Irangaid", referencedColumnName="id")
     * })
     */
    private $fkIrangaid;

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

