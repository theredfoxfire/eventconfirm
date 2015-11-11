<?php

namespace AppBundle\Entity;

/**
 * Peserta
 */
class Peserta
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $present;

    /**
     * @var boolean
     */
    private $print;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Peserta
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Peserta
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
     * Set gender
     *
     * @param string $gender
     *
     * @return Peserta
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set origin
     *
     * @param string $origin
     *
     * @return Peserta
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Peserta
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Peserta
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Peserta
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set present
     *
     * @param boolean $present
     *
     * @return Peserta
     */
    public function setPresent($present)
    {
        $this->present = $present;

        return $this;
    }

    /**
     * Get present
     *
     * @return boolean
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * Set print
     *
     * @param boolean $print
     *
     * @return Peserta
     */
    public function setPrint($print)
    {
        $this->print = $print;

        return $this;
    }

    /**
     * Get print
     *
     * @return boolean
     */
    public function getPrint()
    {
        return $this->print;
    }
    
    protected $cetak;
    
    public function getCetak()
    {
		return ($this->print == true ? $this->cetak = "Ya" : $this->cetak = "Tidak");
        
    }
    
    /**
     * @var string
     */
    private $pod;

    /**
     * @var string
     */
    private $bod;


    /**
     * Set pod
     *
     * @param string $pod
     *
     * @return Peserta
     */
    public function setPod($pod)
    {
        $this->pod = $pod;

        return $this;
    }

    /**
     * Get pod
     *
     * @return string
     */
    public function getPod()
    {
        return $this->pod;
    }

    /**
     * Set bod
     *
     * @param string $bod
     *
     * @return Peserta
     */
    public function setBod($bod)
    {
        $this->bod = $bod;

        return $this;
    }

    /**
     * Get bod
     *
     * @return string
     */
    public function getBod()
    {
        return $this->bod;
    }
}
