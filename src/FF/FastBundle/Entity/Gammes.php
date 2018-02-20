<?php

namespace FF\FastBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gammes
 *
 * @ORM\Table(name="gammes")
 * @ORM\Entity(repositoryClass="FF\FastBundle\Repository\GammesRepository")
 */
class Gammes
{
     /**
     * @ORM\OneToOne(targetEntity="FF\FastBundle\Entity\Images", cascade={"persist"})
     */
    private $images;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = null;


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
     * @return Gammes
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
        return $this->date = new \Datetime();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Gammes
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
     * @return Gammes
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
     * Set images
     *
     * @param \FF\FastBundle\Entity\Images $images
     *
     * @return Gammes
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
}
