<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AikstynoTvarkymas
 *
 * @ORM\Table(name="Aikstyno_tvarkymas", indexes={@ORM\Index(name="tvarkomas", columns={"fk_Aikstynasid"}), @ORM\Index(name="tvarko", columns={"fk_Darbuotojasid"})})
 * @ORM\Entity
 */
class AikstynoTvarkymas
{
    /**
     * @var string
     *
     * @ORM\Column(name="komentaras", type="string", length=500, nullable=true)
     */
    private $komentaras;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pradzios_laikas", type="date", nullable=true)
     */
    private $pradziosLaikas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pabaigos_laikas", type="date", nullable=true)
     */
    private $pabaigosLaikas;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Darbuotojas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Darbuotojas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Darbuotojasid", referencedColumnName="id")
     * })
     */
    private $fkDarbuotojasid;

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

