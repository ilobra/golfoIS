<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aikstynas
 *
 * @ORM\Table(name="Aikstynas")
 * @ORM\Entity
 */
class Aikstynas
{
    /**
     * @var string
     *
     * @ORM\Column(name="aikstyno_info", type="string", length=500, nullable=false)
     */
    private $aikstynoInfo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function setAikstynoInfo($aikstynoInfo)
    {
        $this->aikstynoInfo = $aikstynoInfo;

        return $this;
    }

    /**
     * Get aikstynoInfo
     *
     * @return string
     */
    public function getAikstynoInfo()
    {
        return $this->aikstynoInfo;
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
}


