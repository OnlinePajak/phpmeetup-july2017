<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 11/07/2017
 * Time: 14.34
 */

namespace ApiBundle\Builder;


use AppBundle\Entity\StockTransaction;
use Doctrine\ORM\EntityManager;

class StockTransactionBuilder
{
    public function buildStockTransaction($params, $item, $stockTransaction = null){
        if($stockTransaction == null){
            $stockTransaction = new StockTransaction();
        }
        $stockTransaction->setIncomingStock($params["incoming_stock"]);
        $stockTransaction->setQuantity($params["quantity"]);
        $stockTransaction->setItem($item);
        return $stockTransaction;
    }
}