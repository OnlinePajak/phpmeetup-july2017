<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 11/07/2017
 * Time: 14.34
 */

namespace ApiBundle\Builder;


use AppBundle\Entity\Transaction;
use Doctrine\ORM\EntityManager;

class TransactionBuilder
{
    public function buildTransaction($params,$item, $transaction = null){
        if($transaction == null){
            $transaction = new Transaction();
        }
        $transaction->setQuantity($params["quantity"]);
        $transaction->setItem($item);
        $transaction->setItemPrice($params["item_price"]);
        $transaction->setSubtotalPrice($params["subtotal_price"]);
        return $transaction;
    }
}