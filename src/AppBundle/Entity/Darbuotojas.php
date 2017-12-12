<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Darbuotojas
 *
 * @ORM\Table(name="Darbuotojas")
 * @ORM\Entity
 */
class Darbuotojas
{
    /**
     * @var string
     *
     * @ORM\Column(name="uzmokestis", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $uzmokestis;

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
     * @return string
     */
    public function getUzmokestis()
    {
        return $this->uzmokestis;
    }

    /**
     * @param string $uzmokestis
     */
    public function setUzmokestis($uzmokestis)
    {
        $this->uzmokestis = $uzmokestis;
    }


}

