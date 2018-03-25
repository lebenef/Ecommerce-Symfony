<?php
namespace FF\FastBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FF\FastBundle\Entity\Produits;

#use AppBundle\Entity\User;
#use AppBundle\Entity\Product;
/**
 * @ORM\Entity
 * @ORM\Table(name="shipping")
 */
class Shipping
{
    
   /**
     * @ORM\Column(type="integer")
     */
    private $quantity;
    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="FF\FastBundle\Entity\Produits") 
     */
    protected $produits;
    /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="FF\FastBundle\Entity\Cart") 
     */
    protected $cart;
    

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Shipping
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set produits
     *
     * @param \FF\FastBundle\Entity\Produits $produits
     *
     * @return Shipping
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
     * Set cart
     *
     * @param \FF\FastBundle\Entity\Cart $cart
     *
     * @return Shipping
     */
    public function setCart(\FF\FastBundle\Entity\Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \FF\FastBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }
  
  
      /**
     * Set view
     *
     * @param FormView $view
     *
     * @return Produits
     */
  
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
}
