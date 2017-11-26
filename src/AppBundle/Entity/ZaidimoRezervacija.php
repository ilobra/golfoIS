<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZaidimoRezervacija
 *
 * @ORM\Table(name="Zaidimo_rezervacija", indexes={@ORM\Index(name="skiriama", columns={"fk_Aikstynasid"}), @ORM\Index(name="sukuria_turnyra_rezervuoja_zaidima", columns={"fk_Narysid"})})
 * @ORM\Entity
 */
class ZaidimoRezervacija
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pradzios_laikas", type="date", nullable=false)
     */
    private $pradziosLaikas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pabaigos_laikas", type="date", nullable=false)
     */
    private $pabaigosLaikas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=255, nullable=true)
     */
    private $pavadinimas;

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

