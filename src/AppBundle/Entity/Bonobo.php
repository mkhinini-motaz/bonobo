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
     * Liste des Bonobo qui sont amis avec ce Bonobo, ce champs sera rempli lorsqu'on un Bonobo ajoute ce Bonobo à sa liste d'amis
     * @ORM\ManyToMany(targetEntity="Bonobo", mappedBy="myFriends")
     */
    private $friendsWithMe;

    /**
     * La liste des amis de ce Bonobo, ce champs sera rempli lorsque ce Bonobo ajoute d'autres Bonbo à sa liste d'amis
     * @ORM\ManyToMany(targetEntity="Bonobo", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="bonobo_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_bonobo_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    /**
     * Liste des Bonobo qui sont de la même famille que ce Bonobo, ce champs sera rempli lorsque un Bonobo ajoute ce Bonobo à sa famille
     * @ORM\OneToMany(targetEntity="Family", mappedBy="familyMember")
     * @ORM\JoinTable(name="family")
     */
    private $familyWithMe;

    /**
     * La liste de la famille de ce Bonobo, ce champs sera rempli lorsque ce Bonobo ajoute d'autres Bonbo à sa liste de famille
     * @ORM\OneToMany(targetEntity="Family", mappedBy="bonobo")
     * @ORM\JoinTable(name="family")
     */
    private $myFamily;


    public function __construct() {
        $this->account = null;
        $this->friendsWithMe = new ArrayCollection();
        $this->myFriends = new ArrayCollection();
        $this->familyWithMe = new ArrayCollection();
        $this->myFamily = new ArrayCollection();
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

    /**
     * Add familyWithMe
     *
     * @param \AppBundle\Entity\Family $familyWithMe
     *
     * @return Bonobo
     */
    public function addFamilyWithMe(\AppBundle\Entity\Family $familyWithMe)
    {
        $this->familyWithMe[] = $familyWithMe;

        return $this;
    }

    /**
     * Remove familyWithMe
     *
     * @param \AppBundle\Entity\Family $familyWithMe
     */
    public function removeFamilyWithMe(\AppBundle\Entity\Family $familyWithMe)
    {
        $this->familyWithMe->removeElement($familyWithMe);
    }

    /**
     * Get familyWithMe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFamilyWithMe()
    {
        return $this->familyWithMe;
    }

    /**
     * Add myFamily
     *
     * @param \AppBundle\Entity\Family $myFamily
     *
     * @return Bonobo
     */
    public function addMyFamily(\AppBundle\Entity\Family $myFamily)
    {
        $this->myFamily[] = $myFamily;

        return $this;
    }

    /**
     * Remove myFamily
     *
     * @param \AppBundle\Entity\Family $myFamily
     */
    public function removeMyFamily(\AppBundle\Entity\Family $myFamily)
    {
        $this->myFamily->removeElement($myFamily);
    }

    /**
     * Get myFamily
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFamily()
    {
        return $this->myFamily;
    }

    /**
     * Supprimer un membre de famille
     *
     * @param \AppBundle\Entity\Bonobo $bonobo
     *
     * @return \AppBundle\Entity\Family routroune un objet family pour qu'il soit supprimé de la base de données à partir du controlleur
     */
    public function removeFromFamily(\AppBundle\Entity\Bonobo $bonobo)
    {
        foreach ($this->myFamily as $family) {
            if ($family->getFamilyMember()->getId() == $bonobo->getId()) {
                $this->removeMyFamily($family);
                return $family;
            }
        }
        foreach ($this->familyWithMe as $family) {
            if ($family->getFamilyMember()->getId() == $bonobo->getId()) {
                $this->removeFamilyWithMe($family);
                return $family;
            }
        }
    }

    /**
     * Vérifier si un Bonobo est ami avec ce Bonobo
     *
     * @param \AppBundle\Entity\Bonobo $bonobo
     *
     * @return boolean
     */
    public function isNotFriendWith(\AppBundle\Entity\Bonobo $bonobo)
    {
        if ($bonobo->getId() == $this->getId()) {
            return false;
        }
        foreach ($this->myFriends as $friend) {
            if ($friend->getId() == $bonobo->getId()) {
                return false;
            }
        }
        foreach ($this->friendsWithMe as $friend) {
            if ($friend->getId() == $bonobo->getId()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Vérifier si un Bonobo est ami avec ce Bonobo
     *
     * @param \AppBundle\Entity\Bonobo $bonobo
     *
     * @return boolean
     */
    public function isNotFamilyMember(\AppBundle\Entity\Bonobo $bonobo)
    {
        if ($bonobo->getId() == $this->getId()) {
            return false;
        }
        foreach ($this->myFamily as $family) {
            if ($family->getBonobo()->getId() == $bonobo->getId() || $family->getFamilyMember()->getId() == $bonobo->getId()) {
                return false;
            }
        }
        foreach ($this->familyWithMe as $family) {
            if ($family->getFamilyMember()->getId() == $bonobo->getId() || $family->getBonobo()->getId() == $bonobo->getId()) {
                return false;
            }
        }
        return true;
    }

}
