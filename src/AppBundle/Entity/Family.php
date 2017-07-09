<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Family
 *
 * @ORM\Table(name="family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FamilyRepository")
 */
class Family
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="relation", type="string", length=20)
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity="Bonobo", inversedBy="myFamily")
     * @ORM\JoinColumn(name="bonobo_id", referencedColumnName="id")
     */
    protected $bonobo;

    /**
     * @ORM\ManyToOne(targetEntity="Bonobo", inversedBy="familyWithMe")
     * @ORM\JoinColumn(name="family_member_id", referencedColumnName="id")
     */
    protected $familyMember;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set relation
     *
     * @param string $relation
     *
     * @return Family
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get relation
     *
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set bonobo
     *
     * @param \AppBundle\Entity\Bonobo $bonobo
     *
     * @return Family
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

    /**
     * Set familyMember
     *
     * @param \AppBundle\Entity\Bonobo $familyMember
     *
     * @return Family
     */
    public function setFamilyMember(\AppBundle\Entity\Bonobo $familyMember = null)
    {
        $this->familyMember = $familyMember;

        return $this;
    }

    /**
     * Get familyMember
     *
     * @return \AppBundle\Entity\Bonobo
     */
    public function getFamilyMember()
    {
        return $this->familyMember;
    }
}
