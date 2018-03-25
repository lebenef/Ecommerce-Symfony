<?php
 
namespace FF\FastBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use FF\FastBundle\Entity\CommandeProduit;
use FF\UserBundle\Entity\User;
 
/**
 * Commande
 *
* @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="FF\FastBundle\Repository\CommandeRepository")
 */
class Commande
{
   /**
   * @ORM\ManyToOne(targetEntity="FF\UserBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   * @ORM\OrderBy({"date" = "DESC"})
   */
   private $user;
  
   /**
   * @ORM\ManyToOne(targetEntity="FF\UserBundle\Entity\User")
   * @ORM\JoinColumn(nullable=true)
   */
   private $livreur = null;
  
   /**
   * @ORM\OneToMany(targetEntity="FF\FastBundle\Entity\CommandeProduit", mappedBy="commande", cascade={"all"})
   */
  private $commandeproduit;
 
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
     * @ORM\Column(name="etat", type="string", length=1)
     */
    private $etat;
  
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date = null;
    /**
     * @var float
     *
     * @ORM\Column(name="price", scale=2, type="float")
     */
    private $price;
    /**
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandeproduit = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \Datetime();
        $this->etat = 0;  
        $this->pfice = null;  
          
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
     * Set user
     *
     * @param \FF\UserBundle\Entity\User $user
     *
     * @return Commande
     */
    public function setUser(\FF\UserBundle\Entity\User $user)
    {
        $this->user = $user;
 
        return $this;
    }
 
    /**
     * Get user
     *
     * @return \FF\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
 
    /**
     * Add commandeproduit
     *
     * @param \FF\FastBundle\Entity\CommandeProduit $commandeproduit
     *
     * @return Commande
     */
    public function addCommandeproduit(\FF\FastBundle\Entity\CommandeProduit $commandeproduit)
    {
        $this->commandeproduit[] = $commandeproduit;
 
        return $this;
    }
 
    /**
     * Remove commandeproduit
     *
     * @param \FF\FastBundle\Entity\CommandeProduit $commandeproduit
     */
    public function removeCommandeproduit(\FF\FastBundle\Entity\CommandeProduit $commandeproduit)
    {
        $this->commandeproduit->removeElement($commandeproduit);
    }
 
    /**
     * Get commandeproduit
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandeproduit()
    {
        return $this->commandeproduit;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Commande
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set livreur
     *
     * @param \FF\UserBundle\Entity\User $livreur
     *
     * @return Commande
     */
    public function setLivreur(\FF\UserBundle\Entity\User $livreur = null)
    {
        $this->livreur = $livreur;

        return $this;
    }

    /**
     * Get livreur
     *
     * @return \FF\UserBundle\Entity\User
     */
    public function getLivreur()
    {
        return $this->livreur;
    }
}
