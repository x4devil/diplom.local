<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoriesRequests
 *
 * @ORM\Table(name="inventories_requests", indexes={@ORM\Index(name="id_inventory", columns={"id_inventory"}), @ORM\Index(name="id_request", columns={"id_request"})})
 * @ORM\Entity
 */
class InventoriesRequests
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Requests
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Requests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_request", referencedColumnName="id_request")
     * })
     */
    private $idRequest;

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
     * Set date
     *
     * @param \DateTime $date
     * @return InventoriesRequests
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idRequest
     *
     * @param \AppBundle\Entity\Requests $idRequest
     * @return InventoriesRequests
     */
    public function setIdRequest(\AppBundle\Entity\Requests $idRequest = null)
    {
        $this->idRequest = $idRequest;

        return $this;
    }

    /**
     * Get idRequest
     *
     * @return \AppBundle\Entity\Requests 
     */
    public function getIdRequest()
    {
        return $this->idRequest;
    }

    /**
     * Set idInventory
     *
     * @param \AppBundle\Entity\Inventories $idInventory
     * @return InventoriesRequests
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
