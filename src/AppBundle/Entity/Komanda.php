<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Komanda
 *
 * @ORM\Table(name="Komanda")
 * @ORM\Entity
 */
class Komanda
{
    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=40, nullable=false)
     */
    private $pavadinimas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ikurimo_data", type="date", nullable=false)
     */
    private $ikurimoData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

