<?php
 
namespace FF\FastBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use FF\FastBundle\Entity\Produits;
use FF\FastBundle\Entity\Commande;
 
/**
 * CommandeProduits
 *
 * @ORM\Table(name="commandeproduit")
 * @ORM\Entity(repositoryClass="FF\FastBundle\Repository\CommandeRepository")
 */
class CommandeProduit
{
   /**
   * @ORM\ManyToOne(targetEntity="FF\FastBundle\Entity\Commande" ,inversedBy="commandeproduit")
   */
   private $commande;
   /**
   * @ORM\ManyToOne(targetEntity="FF\FastBundle\Entity\Produits")
   * @ORM\JoinColumn(nullable=false)
   */
  private $produits;
   
  /**
   * @ORM\ManyToOne(targetEntity="FF\UserBundle\Entity\User")
   * @ORM\JoinColumn(nullable=true)
   */
   private $cuisinier = null;
     
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
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \Datetime();
        $this->etat = 0;  
          
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
     * Set commande
     *
     * @param \FF\FastBundle\Entity\Commande $commande
     *
     * @return CommandeProduit
     */
    public function setCommande(\FF\FastBundle\Entity\Commande $commande = null)
    {
        $this->commande = $commande;
 
        return $this;
    }
 
    /**
     * Get commande
     *
     * @return \FF\FastBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
 
    /**
     * Set produits
     *
     * @param \FF\FastBundle\Entity\Produits $produits
     *
     * @return CommandeProduit
     */
    public function setProduits(\FF\FastBundle\Entity\Produits $produits)
    {
        $this->produits = $produits;
 
        return $this;
    }
 
    /**
     * Get produits
     *
     * @return \FF\FastBundle\Entity\Produits
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return CommandeProduit
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
  
        public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return FormView
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set cuisinier
     *
     * @param \FF\UserBundle\Entity\User $cuisinier
     *
     * @return CommandeProduit
     */
    public function setCuisinier(\FF\UserBundle\Entity\User $cuisinier = null)
    {
        $this->cuisinier = $cuisinier;

        return $this;
    }

    /**
     * Get cuisinier
     *
     * @return \FF\UserBundle\Entity\User
     */
    public function getCuisinier()
    {
        return $this->cuisinier;
    }
}
