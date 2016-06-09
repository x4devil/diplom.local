<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Images
 *
 * @ORM\Table(name="images", indexes={@ORM\Index(name="id_inventory", columns={"id_inventory"})})
 * @ORM\Entity
 */
class Images
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_image", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idImage;

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
     * Get idImage
     *
     * @return integer 
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * Set idInventory
     *
     * @param \AppBundle\Entity\Inventories $idInventory
     * @return Images
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
