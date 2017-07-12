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
        $result["result"] = $stockTransactions;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function fetchStockTransactionDetail($id){
        $stockTransaction = $this->em->getRepository('AppBundle:StockTransaction')->find($id);
        $result["result"] = $stockTransaction;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function createStockTransaction($input){
        $item = $this->itemService->fetchItem($input["item_id"]);
        $stockTransaction = $this->stockTransactionBuilder->buildStockTransaction($input,$item);
        $this->em->persist($stockTransaction);
        $this->em->flush();

        $result["result"] = $stockTransaction;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function updateStockTransaction($input){
        $stockTransactionObject = $this->em->getRepository('AppBundle:StockTransaction')->find($input["id"]);
        $itemObject = $this->em->getRepository('AppBundle:Item')->find($stockTransactionObject->getItemId());
        $stockTransaction = $this->stockTransactionBuilder->buildStockTransaction($input,$item,$stockTransaction);
        $this->em->persist($stockTransaction);
        $this->em->flush();

        $result["result"] = $stockTransaction;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function confirmStockTransaction($id){
        $stockTransactionObject = $this->em->getRepository('AppBundle:StockTransaction')->find($id);
        $itemObject = $this->em->getRepository('AppBundle:Item')->find($stockTransactionObject->getItemId());

        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

}