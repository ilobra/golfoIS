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
     * @var \Time
     *
     * @ORM\Column(name="pradzios_laikas", type="time", nullable=false)
     */
    private $pradziosLaikas;

    /**
     * @var \Time
     *
     * @ORM\Column(name="pabaigos_laikas", type="time", nullable=false)
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

        /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return ZaidimoRezervacija
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set pradziosLaikas
     *
     * @param \DateTime $pradziosLaikas
     *
     * @return ZaidimoRezervacija
     */
    public function setPradziosLaikas($pradziosLaikas)
    {
        $this->pradziosLaikas = $pradziosLaikas;

        return $this;
    }

    /**
     * Get pradziosLaikas
     *
     * @return \DateTime
     */
    public function getPradziosLaikas()
    {
        return $this->pradziosLaikas;
    }

    /**
     * Set pabaigosLaikas
     *
     * @param \DateTime $pabaigosLaikas
     *
     * @return ZaidimoRezervacija
     */
    public function setPabaigosLaikas($pabaigosLaikas)
    {
        $this->pabaigosLaikas = $pabaigosLaikas;

        return $this;
    }

    /**
     * Get pabaigosLaikas
     *
     * @return \DateTime
     */
    public function getPabaigosLaikas()
    {
        return $this->pabaigosLaikas;
    }

    /**
     * Set pavadinimas
     *
     * @param string $pavadinimas
     *
     * @return ZaidimoRezervacija
     */
    public function setPavadinimas($pavadinimas)
    {
        $this->pavadinimas = $pavadinimas;

        return $this;
    }

    /**
     * Get pavadinimas
     *
     * @return string
     */
    public function getPavadinimas()
    {
        return $this->pavadinimas;
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
     * @return ZaidimoRezervacija
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
     * @return ZaidimoRezervacija
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

