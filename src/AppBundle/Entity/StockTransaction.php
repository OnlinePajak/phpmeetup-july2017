<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockTransaction
 *
 * @ORM\Table(name="stockTransaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StockTransactionRepository")
 */
class StockTransaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="item_id", type="integer")
     */
    private $itemId;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="incoming_stock", type="integer", length=1, nullable=false)
     */
    private $incomingStock;

    /**
     * @var int
     *
     * @ORM\Column(name="confirmation_status", type="integer", options={"default" = 0})
     */
    private $confirmationStatus;


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
     * Set itemId
     *
     * @param integer $itemId
     *
     * @return StockTransaction
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return StockTransaction
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getConfirmationStatus()
    {
        return $this->confirmationStatus;
    }

    /**
     * @param int $confirmationStatus
     */
    public function setConfirmationStatus($confirmationStatus)
    {
        $this->confirmationStatus = $confirmationStatus;
    }

    /**
     * @return int
     */
    public function getIncomingStock()
    {
        return $this->incomingStock;
    }

    /**
     * @param int $incomingStock
     */
    public function setIncomingStock($incomingStock)
    {
        $this->incomingStock = $incomingStock;
    }

}

