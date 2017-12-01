<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Turnyras
 *
 * @ORM\Table(name="Turnyras", indexes={@ORM\Index(name="priskirta", columns={"fk_Zaidimo_rezervacijaid"}), @ORM\Index(name="dalyvauja", columns={"fk_Narysid"})})
 * @ORM\Entity
 */
class Turnyras
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    private $id;

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
     * @var \AppBundle\Entity\ZaidimoRezervacija
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ZaidimoRezervacija")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Zaidimo_rezervacijaid", referencedColumnName="id")
     * })
     */
    private $fkZaidimoRezervacijaid;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set fkZaidimoRezervacijaid
     *
     * @param \AppBundle\Entity\ZaidimoRezervacija $fkZaidimoRezervacijaid
     *
     * @return Turnyras
     */
    public function setFkZaidimoRezervacijaid(\AppBundle\Entity\ZaidimoRezervacija $fkZaidimoRezervacijaid = null)
    {
        $this->fkZaidimoRezervacijaid = $fkZaidimoRezervacijaid;

        return $this;
    }

    /**
     * Get fkZaidimoRezervacijaid
     *
     * @return \AppBundle\Entity\ZaidimoRezervacija
     */
    public function getFkZaidimoRezervacijaid()
    {
        return $this->fkZaidimoRezervacijaid;
    }

    /**
     * Set fkNarysid
     *
     * @param \AppBundle\Entity\Narys $fkNarysid
     *
     * @return Turnyras
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


}

