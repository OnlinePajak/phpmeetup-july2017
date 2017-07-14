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
     * @ORM\Column(name="item_price", type="integer", options={"default" = 0})
     */
    private $itemPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="subtotal_price", type="integer", options={"default" = 0})
     */
    private $subtotal_price;




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
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    /**
     * @param int $itemPrice
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return int
     */
    public function getSubtotalPrice()
    {
        return $this->subtotal_price;
    }

    /**
     * @param int $subtotal_price
     */
    public function setSubtotalPrice($subtotal_price)
    {
        $this->subtotal_price = $subtotal_price;
    }

}

