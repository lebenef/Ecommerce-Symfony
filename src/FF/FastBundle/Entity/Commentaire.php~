<?php
 
namespace FF\FastBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use FF\FastBundle\Entity\Produit;
use FF\UserBundle\Entity\User;
 
/**
 * Commentaire
 *
* @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="FF\FastBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
  
  /**
   * @ORM\ManyToOne(targetEntity="FF\FastBundle\Entity\Produits")
   * @ORM\JoinColumn(nullable=false)
   */
  private $produits;
  
   /**
   * @ORM\ManyToOne(targetEntity="FF\UserBundle\Entity\User")
   * @ORM\JoinColumn(nullable=true)
   */
   private $user=null;

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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $commentaire= null;
  
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();
          
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commentaire
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
     * Set produits
     *
     * @param \FF\FastBundle\Entity\Produits $produits
     *
     * @return Commentaire
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
     * Set user
     *
     * @param \FF\UserBundle\Entity\User $user
     *
     * @return Commentaire
     */
    public function setUser(\FF\UserBundle\Entity\User $user = null)
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
}
