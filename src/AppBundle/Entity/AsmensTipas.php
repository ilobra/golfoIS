<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AsmensTipas
 *
 * @ORM\Table(name="Asmens_tipas")
 * @ORM\Entity
 */
class AsmensTipas
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=31, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Asmens_tipas", type="integer")
     * @ORM\Id
     *
     */
    private $idAsmensTipas;


}

