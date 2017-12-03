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

    
    /**
     * Set kokybe
     *
     * @param string $kokybe
     *
     * @return Iranga
     */
    public function setKokybe($kokybe)
    {
        $this->kokybe = $kokybe;

        return $this;
    }

    /**
     * Get kokybe
     *
     * @return string
     */
    public function getKokybe()
    {
        return $this->kokybe;
    }

    /**
     * Set isigijimoData
     *
     * @param \DateTime $isigijimoData
     *
     * @return Iranga
     */
    public function setIsigijimoData($isigijimoData)
    {
        $this->isigijimoData = $isigijimoData;

        return $this;
    }

    /**
     * Get isigijimoData
     *
     * @return \DateTime
     */
    public function getIsigijimoData()
    {
        return $this->isigijimoData;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tipas
     *
     * @param \AppBundle\Entity\IrangosTipas $tipas
     *
     * @return Iranga
     */
    public function setTipas(\AppBundle\Entity\IrangosTipas $tipas = null)
    {
        $this->tipas = $tipas;

        return $this;
    }

    /**
     * Get tipas
     *
     * @return \AppBundle\Entity\IrangosTipas
     */
    public function getTipas()
    {
        return $this->tipas;
    }


}

