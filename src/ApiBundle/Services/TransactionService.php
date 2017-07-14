<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 07/07/2017
 * Time: 16.25
 */

namespace ApiBundle\Services;

use ApiBundle\Builder\TransactionBuilder;
use AppBundle\Services\CommonService;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;

class TransactionService
{
    private $em;
    private $commonService;
    private $transactionBuilder;
    private $result;

    public function __construct(EntityManagerInterface $em, CommonService $commonService)
    {
        $this->em = $em;
        $this->transactionBuilder = new TransactionBuilder();
        $this->commonService = $commonService;
        $this->result = $this->commonService->setPredefinedResult();
    }

    public function fetchTransactionList()
    {
        $transactionObjects = $this->commonService->fetchTransactionObject();
        $this->result = $this->commonService->setResult($transactionObjects);
        return $this->result;
    }

    public function fetchTransactionDetail($id)
    {
        $transactionObject = $this->commonService->fetchTransactionObject($id);
        if ($transactionObject) {
            $this->result = $this->commonService->setResult($transactionObject);
        }

        return $this->result;
    }

    public function createTransaction($input)
    {
        $itemObject = $this->commonService->fetchItemObject($input["item_id"]);
        if($itemObject){
            $input["item_price"] = $itemObject->getPrice();
            $input["subtotal_price"] = $input["quantity"] * $input["item_price"];
            $transactionObject = $this->transactionBuilder->buildTransaction($input, $itemObject);
            $this->em->persist($transactionObject);
            $this->em->flush();
            $this->result = $this->commonService->setResult($transactionObject);
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Item");
        }



        return $this->result;
    }

    public function updateTransaction($input)
    {
        $transactionObject = $this->commonService->fetchTransactionObject($input["id"]);

        if ($transactionObject) {
            $itemObject = $transactionObject->getItem();
            if($itemObject){
                $input["item_price"] = $itemObject->getPrice();
                $input["subtotal_price"] = $input["quantity"] * $input["item_price"];
                $transactionObject = $this->transactionBuilder->buildTransaction($input, $itemObject, $transactionObject);
                $this->em->persist($transactionObject);
                $this->em->flush();
                $this->result = $this->commonService->setResult($transactionObject);
            }else{
                $this->result = $this->commonService->setFailedResult("Invalid Item");
            }
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Transaction");
        }

        return $this->result;
    }

    public function confirmTransaction($id)
    {
        $transactionObject = $this->commonService->fetchTransactionObject($id);
        $itemObject = $transactionObject->getItem();

        if ($transactionObject) {
            if($itemObject){
                $incomingStockStatus = $transactionObject->getIncomingStock();
                $transactionQuantity = $transactionObject->getQuantity();
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
            $this->result = $this->commonService->setFailedResult("Invalid Transaction");
        }

        return $this->result;
    }

    public function removeTransaction($id)
    {
        $transactionObject = $this->commonService->fetchTransactionObject($id);
        if ($transactionObject) {
            $this->em->remove($transactionObject);
            $this->em->flush();

            $this->result = $this->commonService->setResult($transactionObject);
        }else{
            $this->result = $this->commonService->setFailedResult("Invalid Transaction");
        }

        return $this->result;
    }

}