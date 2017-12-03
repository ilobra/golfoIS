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

    /**
     * Set suma
     *
     * @param string $suma
     *
     * @return IrangosApmokejimas
     */
    public function setSuma($suma)
    {
        $this->suma = $suma;

        return $this;
    }

    /**
     * Get suma
     *
     * @return string
     */
    public function getSuma()
    {
        return $this->suma;
    }

    /**
     * Set isnuomojimoPradzia
     *
     * @param \DateTime $isnuomojimoPradzia
     *
     * @return IrangosApmokejimas
     */
    public function setIsnuomojimoPradzia($isnuomojimoPradzia)
    {
        $this->isnuomojimoPradzia = $isnuomojimoPradzia;

        return $this;
    }

    /**
     * Get isnuomojimoPradzia
     *
     * @return \DateTime
     */
    public function getIsnuomojimoPradzia()
    {
        return $this->isnuomojimoPradzia;
    }

    /**
     * Set isnuomojimoPabaiga
     *
     * @param \DateTime $isnuomojimoPabaiga
     *
     * @return IrangosApmokejimas
     */
    public function setIsnuomojimoPabaiga($isnuomojimoPabaiga)
    {
        $this->isnuomojimoPabaiga = $isnuomojimoPabaiga;

        return $this;
    }

    /**
     * Get isnuomojimoPabaiga
     *
     * @return \DateTime
     */
    public function getIsnuomojimoPabaiga()
    {
        return $this->isnuomojimoPabaiga;
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
     * Set fkNarysid
     *
     * @param \AppBundle\Entity\Narys $fkNarysid
     *
     * @return IrangosApmokejimas
     */
    public function setFkNarysid(\AppBundle\Entity\Narys $fkNarysid = null)
    {
        $this->fkNarysid = $fkNarysid;

        return $this;
    }

    /**
     * Get fkNarysid
     *
     * @return \AppBundle\Entity\Narys
     */
    public function getFkNarysid()
    {
        return $this->fkNarysid;
    }

    /**
     * Set fkIrangaid
     *
     * @param \AppBundle\Entity\Iranga $fkIrangaid
     *
     * @return IrangosApmokejimas
     */
    public function setFkIrangaid(\AppBundle\Entity\Iranga $fkIrangaid = null)
    {
        $this->fkIrangaid = $fkIrangaid;

        return $this;
    }

    /**
     * Get fkIrangaid
     *
     * @return \AppBundle\Entity\Iranga
     */
    public function getFkIrangaid()
    {
        return $this->fkIrangaid;
    }

}

