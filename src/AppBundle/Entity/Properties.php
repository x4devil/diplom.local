<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Properties
 *
 * @ORM\Table(name="properties", indexes={@ORM\Index(name="id_category", columns={"id_category"})})
 * @ORM\Entity
 */
class Properties
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_properties", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProperties;

    /**
     * @var \AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_category", referencedColumnName="id_category")
     * })
     */
    private $idCategory;



    /**
     * Set name
     *
     * @param string $name
     * @return Properties
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
     * Get idProperties
     *
     * @return integer 
     */
    public function getIdProperties()
    {
        return $this->idProperties;
    }

    /**
     * Set idCategory
     *
     * @param \AppBundle\Entity\Category $idCategory
     * @return Properties
     */
    public function setIdCategory(\AppBundle\Entity\Category $idCategory = null)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }
}
