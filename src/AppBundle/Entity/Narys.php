<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Narys
 *
 * @ORM\Table(name="Narys", indexes={@ORM\Index(name="VIP_narys_priklauso", columns={"fk_Komandaid"})})
 * @ORM\Entity
 */
class Narys
{
    /**
     * @var string
     *
     * @ORM\Column(name="banko_kort_numeris", type="string", length=20, nullable=false)
     */
    private $bankoKortNumeris;

    /**
     * @var \AppBundle\Entity\Asmuo
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Asmuo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Komanda
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Komanda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Komandaid", referencedColumnName="id")
     * })
     */
    private $fkKomandaid;


}

