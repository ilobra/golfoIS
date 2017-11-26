<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Asmuo
 *
 * @ORM\Table(name="Asmuo", indexes={@ORM\Index(name="tipas", columns={"tipas"})})
 * @ORM\Entity
 */
class Asmuo implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="vardas", type="string", length=30, nullable=true)
     */
    private $vardas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavarde", type="string", length=40, nullable=true)
     */
    private $pavarde;

    /**
     * @var string
     *
     * @ORM\Column(name="el_pastas", type="string", length=50, nullable=false)
     */
    private $elPastas;

    /**
     * @var string
     *
     * @ORM\Column(name="asmens_kodas", type="string", length=11, nullable=false)
     */
    private $asmensKodas;

    private $plainPassword;
    /**
     * @var string
     *
     * @ORM\Column(name="slaptazodis", type="string", length=64, nullable=false)
     */
    private $slaptazodis;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\AsmensTipas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AsmensTipas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipas", referencedColumnName="id_Asmens_tipas")
     * })
     */
    private $tipas;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVardas()
    {
        return $this->vardas;
    }

    /**
     * @param string $vardas
     */
    public function setVardas($vardas)
    {
        $this->vardas = $vardas;
    }

    /**
     * @return string
     */
    public function getPavarde()
    {
        return $this->pavarde;
    }

    /**
     * @param string $pavarde
     */
    public function setPavarde($pavarde)
    {
        $this->pavarde = $pavarde;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->slaptazodis;
    }


    /**
     * @param string $slaptazodis
     */
    public function setPassword($slaptazodis)
    {
        $this->slaptazodis = $slaptazodis;
    }

    /**
     * @return string
     */
    public function getAsmensKodas()
    {
        return $this->asmensKodas;
    }

    /**
     * @param string $asmensKodas
     */
    public function setAsmensKodas($asmensKodas)
    {
        $this->asmensKodas = $asmensKodas;
    }

    /**
     * @return string
     */
    public function getElPastas()
    {
        return $this->elPastas;
    }

    /**
     * @param string $elPastas
     */
    public function setElPastas($elPastas)
    {
        $this->elPastas = $elPastas;
    }

    /**
     * @return AsmensTipas
     */
    public function getTipas()
    {
        return $this->tipas;
    }

    /**
     * @param AsmensTipas $tipas
     */
    public function setTipas($tipas)
    {
        $this->tipas = $tipas;
    }

    /**
     * @var string
     */
    private $username;

    public function __construct()
    {
        $this->username=$this->vardas.$this->pavarde;
    }
    public function getUsername()
    {
        return $this->elPastas;
    }

    public function getRoles()
    {
        return [ 'ROLE_USER' ];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function eraseCredentials()
    {

    }

    public function __toString()
    {
        return $this->username;
    }

}

