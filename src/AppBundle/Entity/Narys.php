<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="banko_kort_numeris", type="string", length=20, nullable=true)
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

    /**
     * Set bankoKortNumeris
     *
     * @param string $bankoKortNumeris
     *
     * @return Narys
     */
    public function setBankoKortNumeris($bankoKortNumeris)
    {
        $this->bankoKortNumeris = $bankoKortNumeris;

        return $this;
    }

    /**
     * Get bankoKortNumeris
     *
     * @return string
     */
    public function getBankoKortNumeris()
    {
        return $this->bankoKortNumeris;
    }

    /**
     * Set id
     *
     * @param \AppBundle\Entity\Asmuo $id
     *
     * @return Narys
     */
    public function setId(\AppBundle\Entity\Asmuo $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \AppBundle\Entity\Asmuo
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fkKomandaid
     *
     * @param \AppBundle\Entity\Komanda $fkKomandaid
     *
     * @return Narys
     */
    public function setFkKomandaid(\AppBundle\Entity\Komanda $fkKomandaid = null)
    {
        $this->fkKomandaid = $fkKomandaid;

        return $this;
    }

    /**
     * Get fkKomandaid
     *
     * @return \AppBundle\Entity\Komanda
     */
    public function getFkKomandaid()
    {
        return $this->fkKomandaid;
    }

}

