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

     /**
     * Set name
     *
     * @param string $name
     *
     * @return AsmensTipas
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get idAsmensTipas
     *
     * @return integer
     */
    public function getIdAsmensTipas()
    {
        return $this->idAsmensTipas;
    }

    public function __toString()
    {
        return $this->name;
    }
}

