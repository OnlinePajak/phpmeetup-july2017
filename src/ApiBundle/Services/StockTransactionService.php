<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 07/07/2017
 * Time: 16.25
 */

namespace ApiBundle\Services;

use ApiBundle\Builder\StockTransactionBuilder;
use AppBundle\Services\CommonService;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;

class StockTransactionService
{
    private $em;
    private $commonService;
    private $stockTransactionBuilder;
    private $result;

    public function __construct(EntityManagerInterface $em, CommonService $commonService)
    {
        $this->em = $em;
        $this->stockTransactionBuilder = new StockTransactionBuilder();
        $this->commonService = $commonService;
        $this->result = $this->commonService->setPredefinedResult();
    }

    public function fetchStockTransactionList()
    {
        $stockTransactionObjects = $this->commonService->fetchStockTransactionObject();
        $this->result = $this->commonService->setResult($stockTransactionObjects);
        return $this->result;
    }

    public function fetchStockTransactionDetail($id)
    {
        $stockTransactionObject = $this->commonService->fetchStockTransactionObject($id);
        if ($stockTransactionObject) {
            $this->result = $this->commonService->setResult($stockTransactionObject);
        }

        return $this->result;
    }

    public function createStockTransaction($input)
    {
        $itemObject = $this->commonService->fetchItemObject($input["item_id"]);
        if($itemObject){
            $input["item_price"] = $itemObject->getPrice();
            $input["subtotal_price"] = $input["quantity"] * $input["item_price"];
            $stockTransactionObject = $this->stockTransactionBuilder->buildStockTransaction($input, $itemObject);
            $this->em->persist($stockTransactionObject);
            $this->em->flush();
            $this->result = $this->commonService->setResult($stockTransactionObject);
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Item");
        }



        return $this->result;
    }

    public function updateStockTransaction($input)
    {
        $stockTransactionObject = $this->commonService->fetchStockTransactionObject($input["id"]);

        if ($stockTransactionObject) {
            $itemObject = $stockTransactionObject->getItem();
            if($itemObject){
                $input["item_price"] = $itemObject->getPrice();
                $input["subtotal_price"] = $input["quantity"] * $input["item_price"];
                $stockTransactionObject = $this->stockTransactionBuilder->buildStockTransaction($input, $itemObject, $stockTransactionObject);
                $this->em->persist($stockTransactionObject);
                $this->em->flush();
                $this->result = $this->commonService->setResult($stockTransactionObject);
            }else{
                $this->result = $this->commonService->setFailedResult("Invalid Item");
            }
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Stock Transaction");
        }

        return $this->result;
    }

    public function confirmStockTransaction($id)
    {
        $stockTransactionObject = $this->commonService->fetchStockTransactionObject($id);
        $itemObject = $stockTransactionObject->getItem();

        if ($stockTransactionObject) {
            if($itemObject){
                $incomingStockStatus = $stockTransactionObject->getIncomingStock();
                $transactionQuantity = $stockTransactionObject->getQuantity();
                $itemQuantity = $itemObject->getQuantity();
                if($incomingStockStatus==1){
                    $itemQuantity += $transactionQuantity;
                }else{
                    $itemQuantity -= $transactionQuantity;
                    if($itemQuantity < 0) $itemQuantity = 0;
                }
                $itemObject->setQuantity($itemQuantity);
                $this->em->persist($itemObject);
                $this->em->flush();
                $this->result = $this->commonService->setResult($itemObject);
            }else{
                $this->result = $this->commonService->setFailedResult("Invalid Item");
            }
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Stock Transaction");
        }

        return $this->result;
    }

    public function removeStockTransaction($id)
    {
        $stockTransactionObject = $this->commonService->fetchStockTransactionObject($id);
        if ($stockTransactionObject) {
            $this->em->remove($stockTransactionObject);
            $this->em->flush();

            $this->result = $this->commonService->setResult($stockTransactionObject);
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Stock Transaction");
        }

        return $this->result;
    }

}