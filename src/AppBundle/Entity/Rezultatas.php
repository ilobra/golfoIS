<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @ORM\Column(name="raundas", type="integer", nullable=false)
     */
    private $raundas;

    /**
     * @var integer
     * @Assert\NotBlank()
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

    /**
     * Set raundas
     *
     * @param integer $raundas
     *
     * @return Rezultatas
     */
    public function setRaundas($raundas)
    {
        $this->raundas = $raundas;

        return $this;
    }

    /**
     * Get raundas
     *
     * @return integer
     */
    public function getRaundas()
    {
        return $this->raundas;
    }

    /**
     * Set musimuSk
     *
     * @param integer $musimuSk
     *
     * @return Rezultatas
     */
    public function setMusimuSk($musimuSk)
    {
        $this->musimuSk = $musimuSk;

        return $this;
    }

    /**
     * Get musimuSk
     *
     * @return integer
     */
    public function getMusimuSk()
    {
        return $this->musimuSk;
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
     * @return Rezultatas
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
     * Set fkAikstynasid
     *
     * @param \AppBundle\Entity\Aikstynas $fkAikstynasid
     *
     * @return Rezultatas
     */
    public function setFkAikstynasid(\AppBundle\Entity\Aikstynas $fkAikstynasid = null)
    {
        $this->fkAikstynasid = $fkAikstynasid;

        return $this;
    }

    /**
     * Get fkAikstynasid
     *
     * @return \AppBundle\Entity\Aikstynas
     */
    public function getFkAikstynasid()
    {
        return $this->fkAikstynasid;
    }

}

