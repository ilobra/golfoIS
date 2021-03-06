<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Asmuo
 *
 * @ORM\Table(name="Asmuo", indexes={@ORM\Index(name="tipas", columns={"tipas"})})
 * @ORM\Entity
  * @UniqueEntity(fields={"asmensKodas"}, message="Toks vartotojas jau egzistuoja!")
 * @UniqueEntity(fields={"elPastas"}, message="Vartotojas su tokiu el. paštu jau egzistuoja!")
 */
class Asmuo implements UserInterface
{
    /**
     * @var string
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Vardas negali viršyti {{ limit }} simbolių!"
     * )
     * @ORM\Column(name="vardas", type="string", length=30, nullable=true)
     */
    private $vardas;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = 40,
     *      maxMessage = "Pavardė negali viršyti {{ limit }} simbolių!"
     * )
     * @ORM\Column(name="pavarde", type="string", length=40, nullable=true)
     */
    private $pavarde;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "El. paštas negali viršyti {{ limit }} simbolių!"
     * )
     * @ORM\Column(name="el_pastas", type="string", length=50, nullable=false)
     */
    private $elPastas;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = 11,
     *      maxMessage = "Asmens kodas negali viršyti {{ limit }} simbolių!"
     * )
     * @Assert\Length(
     *     min =11,
     *      minMessage="Asmens kodas privalo turėti ne mažiau nei {{ limit }} simbolių!"
     * )
     * @Assert\Regex(
     *        pattern="/^([1-9][0-9]*)$/",
     *        message="Asmens kodas turi būti sudarytas iš skaičių!"
     *      )
     * @ORM\Column(name="asmens_kodas", type="string", length=11, nullable=false)
     */
    private $asmensKodas;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Slaptažodis negali būti trumpesnis nei {{ limit }} simboliai!"
     * )
     */
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

    private $role;

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
    public function getSlaptazodis()
    {
        return $this->slaptazodis;
    }


    /**
     * @param string $slaptazodis
     */
    public function setSlaptazodis($slaptazodis)
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
        if($this->getTipas()->getIdAsmensTipas()==5) {
            $role="ROLE_USER";
            return ['ROLE_USER'];
        }
        else if($this->getTipas()->getIdAsmensTipas()==4){
            $role="ROLE_ADMIN";
            return ['ROLE_ADMIN'];
        }
        else if($this->getTipas()->getIdAsmensTipas()==6){
            $role="ROLE_VIP";
            return ['ROLE_VIP'];
        }
        else if(($this->getTipas()->getIdAsmensTipas()==3)||($this->getTipas()->getIdAsmensTipas()==2)||($this->getTipas()->getIdAsmensTipas()==1)) {//return [ 'ROLE_VIP','ROLE_USER','ROLE_ADMIN','ROLE_PERSONAL' ];
            $role="ROLE_PERSONAL";
            return ['ROLE_PERSONAL'];
        }
    }
    public function setRole($role){
        $this->role=$role;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
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
        if(is_null($this->username)) {
            return 'NULL';
        }
        return $this->username;
    }


}

