<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 07/07/2017
 * Time: 16.25
 */

namespace ApiBundle\Services;

use ApiBundle\Builder\StockTransactionBuilder;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StockTransactionService
{
    private $em;
    private $itemService;
    private $stockTransactionBuilder;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->itemService = new ItemService($em);
        $this->stockTransactionBuilder = new StockTransactionBuilder();
    }

    public function fetchStockTransactionList(){
        $stockTransactions = $this->em->getRepository('AppBundle:StockTransaction')->findAll();
        $i=0;
        foreach($stockTransactions as $stockTransaction){
            $result["result"][$i]["id"] =  $stockTransaction->getId();
            $result["result"][$i]["item_id"] =  $stockTransaction->getItemId();
            $result["result"][$i]["quantity"] =  $stockTransaction->getQuantity();
            $result["result"][$i]["confirmation_status"] =  $stockTransaction->getConfirmationStatus();
            $result["result"][$i]["incoming_stock"] =  $stockTransaction->getIncomingStock();
            $i++;
        }
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function fetchStockTransactionDetail($id){
        $stockTransaction = $this->em->getRepository('AppBundle:StockTransaction')->find($id);
        $result["result"][0]["id"] =  $stockTransaction->getId();
        $result["result"][0]["item_id"] =  $stockTransaction->getItemId();
        $result["result"][0]["quantity"] =  $stockTransaction->getQuantity();
        $result["result"][0]["confirmation_status"] =  $stockTransaction->getConfirmationStatus();
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function createStockTransaction($input){
        $item = $this->itemService->fetchItem($input["item_id"]);
        $stockTransaction = $this->stockTransactionBuilder->buildStockTransaction($input,$item);
        $this->em->persist($stockTransaction);
        $this->em->flush();

        $result["result"]['id'] = $stockTransaction->getId();
        $result["result"]['itemId'] = $stockTransaction->getItemId();
        $result["result"]['quantity'] = $stockTransaction->getQuantity();
        $result["result"]['incomingStock'] = $stockTransaction->getIncomingStock();
        $result["result"]['confirmationStatus'] = $stockTransaction->getConfirmationStatus();
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function updateStockTransaction($input){
        $stockTransaction = $this->fetchStockTransactionDetail($input["stock_transaction_id"]);
        $item = $this->itemService->fetchItem($input["item_id"]);
        $stockTransaction = $this->stockTransactionBuilder->buildStockTransaction($input,$item,$stockTransaction);
        $this->em->persist($stockTransaction);
        $this->em->flush();
        $result["result"] = $stockTransaction;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function confirmStockTransaction($id){
        $stockTransaction = $this->fetchStockTransactionDetail($id);
        $stockTransaction = $this->em->getRepository('AppBundle:StockTransaction')->confirmStockTransaction($stockTransaction);
        $result["result"] = $stockTransaction;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

}