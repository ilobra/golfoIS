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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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


}

