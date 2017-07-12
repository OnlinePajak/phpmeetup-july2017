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
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="stock_transaction", cascade={"persist"})
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     *
     */
    private $item;

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
     * Set Item
     *
     * @param Item $item
     * @return StockTransaction
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
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

