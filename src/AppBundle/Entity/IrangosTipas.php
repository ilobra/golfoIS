<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IrangosTipas
 *
 * @ORM\Table(name="Irangos_tipas")
 * @ORM\Entity
 */
class IrangosTipas
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=11, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Irangos_tipas", type="integer")
     * @ORM\Id
     *
     */
    private $idIrangosTipas;

     /**
     * Set name
     *
     * @param string $name
     *
     * @return IrangosTipas
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
     * Get idIrangosTipas
     *
     * @return integer
     */
    public function getIdIrangosTipas()
    {
        return $this->idIrangosTipas;
    }
}

