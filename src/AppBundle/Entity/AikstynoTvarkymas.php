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
     * @ORM\Column(name="pradzios_laikas", type="time", nullable=true)
     */
    private $pradziosLaikas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pabaigos_laikas", type="time", nullable=true)
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

    /**
     * @return string
     */
    public function getKomentaras()
    {
        return $this->komentaras;
    }

    /**
     * @param string $komentaras
     */
    public function setKomentaras($komentaras)
    {
        $this->komentaras = $komentaras;
    }

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \DateTime $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return \DateTime
     */
    public function getPradziosLaikas()
    {
        return $this->pradziosLaikas;
    }

    /**
     * @param \DateTime $pradziosLaikas
     */
    public function setPradziosLaikas($pradziosLaikas)
    {
        $this->pradziosLaikas = $pradziosLaikas;
    }

    /**
     * @return \DateTime
     */
    public function getPabaigosLaikas()
    {
        return $this->pabaigosLaikas;
    }

    /**
     * @param \DateTime $pabaigosLaikas
     */
    public function setPabaigosLaikas($pabaigosLaikas)
    {
        $this->pabaigosLaikas = $pabaigosLaikas;
    }

    /**
     * @return Darbuotojas
     */
    public function getFkDarbuotojasid()
    {
        return $this->fkDarbuotojasid;
    }

    /**
     * @param Darbuotojas $fkDarbuotojasid
     */
    public function setFkDarbuotojasid($fkDarbuotojasid)
    {
        $this->fkDarbuotojasid = $fkDarbuotojasid;
    }

    /**
     * @return Aikstynas
     */
    public function getFkAikstynasid()
    {
        return $this->fkAikstynasid;
    }

    /**
     * @param Aikstynas $fkAikstynasid
     */
    public function setFkAikstynasid($fkAikstynasid)
    {
        $this->fkAikstynasid = $fkAikstynasid;
    }


}

