<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StovejimoAikstele
 *
 * @ORM\Table(name="Stovejimo_aikstele", uniqueConstraints={@ORM\UniqueConstraint(name="fk_Asmuoid", columns={"fk_Asmuoid"})})
 * @ORM\Entity
 */
class StovejimoAikstele
{
    /**
     * @var string
     *
     * @ORM\Column(name="vietos_nr", type="string", length=50, nullable=false)
     */
    private $vietosNr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="priskyrimo_data", type="date", nullable=false)
     */
    private $priskyrimoData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Asmuo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Asmuo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Asmuoid", referencedColumnName="id")
     * })
     */
    private $fkAsmuoid;


}

