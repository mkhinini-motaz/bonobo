<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abonne
 *
 * @ORM\Table(name="bonobo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BonoboRepository")
 */
class Bonobo
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
     * @ORM\Column(name="name", type="string", length=60, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=60, nullable=true)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="food", type="string", length=60, nullable=true)
     */
    private $food;

    /**
     * Relation entre Bonobo et son Account
     * @ORM\OneToOne(targetEntity="Account", inversedBy="bonobo")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * Constructor
     */

	/**
     * Liste des Bonobo qui sont amis avec ce Bonobo
     * @ORM\ManyToMany(targetEntity="Bonobo", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * La liste des Bonobo
     * @ORM\ManyToMany(targetEntity="Bonobo", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="bonobo_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_bonobo_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    /**
     * Liste des Bonobo qui sont de la même famille que ce Bonobo
     * @ORM\OneToMany(targetEntity="Family", mappedBy="myFamily")
     * @ORM\JoinTable(name="family")
     */
    private $familyWithMe;

    /**
     * La liste des Bonobo
     * @ORM\OneToMany(targetEntity="Family", mappedBy="familyWithMe")
     * @ORM\JoinTable(name="family")
     */
    private $myFamily;



    public function __construct() {
        $this->friendsWithMe = new ArrayCollection();
        $this->myFriends = new ArrayCollection();
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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Bonobo
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
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return Bonobo
     */
    public function setAccount(\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set race
     *
     * @param string $race
     *
     * @return Bonobo
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set food
     *
     * @param string $food
     *
     * @return Bonobo
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return string
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Add friendsWithMe
     *
     * @param \AppBundle\Entity\Bonobo $friendsWithMe
     *
     * @return Bonobo
     */
    public function addFriendsWithMe(\AppBundle\Entity\Bonobo $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \AppBundle\Entity\Bonobo $friendsWithMe
     */
    public function removeFriendsWithMe(\AppBundle\Entity\Bonobo $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriend
     *
     * @param \AppBundle\Entity\Bonobo $myFriend
     *
     * @return Bonobo
     */
    public function addMyFriend(\AppBundle\Entity\Bonobo $myFriend)
    {
        $this->myFriends[] = $myFriend;

        return $this;
    }

    /**
     * Remove myFriend
     *
     * @param \AppBundle\Entity\Bonobo $myFriend
     */
    public function removeMyFriend(\AppBundle\Entity\Bonobo $myFriend)
    {
        $this->myFriends->removeElement($myFriend);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }
}
