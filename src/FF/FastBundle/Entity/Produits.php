<?php

namespace FF\FastBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity(repositoryClass="FF\FastBundle\Repository\ProduitsRepository")
 */
class Produits
{
    /**
    * @ORM\OneToOne(targetEntity="FF\FastBundle\Entity\Images", cascade={"persist"})
    */
   private $images;
   /**
   * @ORM\ManyToOne(targetEntity="FF\FastBundle\Entity\Gammes")
   * @ORM\JoinColumn(nullable=false)
   */
  private $gammes;
  
   /**
   * @ORM\ManyToMany(targetEntity="FF\FastBundle\Entity\Ingredients")
   */
  private $ingredients;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date = null;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255,)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = null;
  
    /**
     * @var float
     *
     * @ORM\Column(name="price", scale=2, type="float")
     */
    private $price;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Produits
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
     * Set name
     *
     * @param string $name
     *
     * @return Produits
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
     * Set description
     *
     * @param string $description
     *
     * @return Produits
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

  
  
  


    /**
     * Set gammes
     *
     * @param \FF\FastBundle\Entity\Gammes $gammes
     *
     * @return Produits
     */
    public function setGammes(\FF\FastBundle\Entity\Gammes $gammes)
    {
        $this->gammes = $gammes;

        return $this;
    }

    /**
     * Get gammes
     *
     * @return \FF\FastBundle\Entity\Gammes
     */
    public function getGammes()
    {
        return $this->gammes;
    }
  
    /**
     * Set ingredients
     *
     * @param \FF\FastBundle\Entity\Ingredients $ingredients
     *
     * @return Ingredients
     */
  
      public function setIngredients(\FF\FastBundle\Entity\Gammes $ingredients)
    {
        $this->ingredient = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return \FF\FastBundle\Entity\Ingredients
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }


    /**
     * Set images
     *
     * @param \FF\FastBundle\Entity\Images $images
     *
     * @return Produits
     */
    public function setImages(\FF\FastBundle\Entity\Images $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \FF\FastBundle\Entity\Images
     */
    public function getImages()
    {
        return $this->images;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingredient
     *
     * @param \FF\FastBundle\Entity\Ingredients $ingredient
     *
     * @return Produits
     */
    public function addIngredient(\FF\FastBundle\Entity\Ingredients $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \FF\FastBundle\Entity\Ingredients $ingredient
     */
    public function removeIngredient(\FF\FastBundle\Entity\Ingredients $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Produits
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
}
