<?php
// src/AppBundle/Entity/Bonobo.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="inscription_date", type="date")
     */
    protected $inscriptionDate;

    /**
     * Relation entre Bonobo et son Compte
     * @ORM\OneToOne(targetEntity="Bonobo", mappedBy="account")
     * @ORM\JoinColumn(name="bonobo_id", referencedColumnName="id")
     */
    private $bonobo;


    public function __construct()
    {
        parent::__construct();
        
    }

    /**
     * Set inscriptionDate
     *
     * @param \DateTime $inscriptionDate
     *
     * @return Account
     */
    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    /**
     * Get inscriptionDate
     *
     * @return \DateTime
     */
    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    /**
     * Set bonobo
     *
     * @param \AppBundle\Entity\Bonobo $bonobo
     *
     * @return Account
     */
    public function setBonobo(\AppBundle\Entity\Bonobo $bonobo = null)
    {
        $this->bonobo = $bonobo;

        return $this;
    }

    /**
     * Get bonobo
     *
     * @return \AppBundle\Entity\Bonobo
     */
    public function getBonobo()
    {
        return $this->bonobo;
    }
}
