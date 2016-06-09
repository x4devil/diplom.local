<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoriesProperties
 *
 * @ORM\Table(name="inventories_properties", indexes={@ORM\Index(name="id_inventory", columns={"id_inventory"}), @ORM\Index(name="id_property", columns={"id_property"})})
 * @ORM\Entity
 */
class InventoriesProperties
{
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Properties
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Properties")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_property", referencedColumnName="id_properties")
     * })
     */
    private $idProperty;

    /**
     * @var \AppBundle\Entity\Inventories
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Inventories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_inventory", referencedColumnName="id_inventory")
     * })
     */
    private $idInventory;



    /**
     * Set value
     *
     * @param string $value
     * @return InventoriesProperties
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
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
     * Set idProperty
     *
     * @param \AppBundle\Entity\Properties $idProperty
     * @return InventoriesProperties
     */
    public function setIdProperty(\AppBundle\Entity\Properties $idProperty = null)
    {
        $this->idProperty = $idProperty;

        return $this;
    }

    /**
     * Get idProperty
     *
     * @return \AppBundle\Entity\Properties 
     */
    public function getIdProperty()
    {
        return $this->idProperty;
    }

    /**
     * Set idInventory
     *
     * @param \AppBundle\Entity\Inventories $idInventory
     * @return InventoriesProperties
     */
    public function setIdInventory(\AppBundle\Entity\Inventories $idInventory = null)
    {
        $this->idInventory = $idInventory;

        return $this;
    }

    /**
     * Get idInventory
     *
     * @return \AppBundle\Entity\Inventories 
     */
    public function getIdInventory()
    {
        return $this->idInventory;
    }
}
