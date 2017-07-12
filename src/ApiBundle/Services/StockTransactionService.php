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
    private $result;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->itemService = new ItemService($em);
        $this->stockTransactionBuilder = new StockTransactionBuilder();
        $this->result["result"] = null;
        $this->result["statusCode"] = Response::HTTP_BAD_REQUEST;
        $this->result["message"] = "Data is not existed";
    }

    public function fetchData($entity, $id = null)
    {
        if ($id) {
            $object = $this->em->getRepository($entity)->find($id);
        } else {
            $object = $this->em->getRepository($entity)->findAll();
        }

        return $object;
    }

    public function fetchStockTransactionList()
    {
        $stockTransactions = $this->fetchData('AppBundle:StockTransaction');
        $result["result"] = $stockTransactions;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function fetchStockTransactionDetail($id)
    {
        $stockTransaction = $this->fetchData('AppBundle:StockTransaction', $id);
        $result["result"] = $stockTransaction;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function createStockTransaction($input)
    {
        $itemObject = $this->fetchData('AppBundle:Item', $input["item_id"]);
        $stockTransactionObject = $this->stockTransactionBuilder->buildStockTransaction($input, $itemObject);
        $this->em->persist($stockTransactionObject);
        $this->em->flush();

        $result["result"] = $stockTransactionObject;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function updateStockTransaction($input)
    {
        $result["result"] = null;
        $result["statusCode"] = Response::HTTP_BAD_REQUEST;
        $result["message"] = "Data is not existed";

        $stockTransactionObject = $this->fetchData('AppBundle:StockTransaction', $input["id"]);
        if($stockTransactionObject){
            $itemObject = $this->fetchData('AppBundle:Item', $stockTransactionObject->getItemId());
            if($stockTransactionObject && $itemObject){
                $stockTransactionObject = $this->stockTransactionBuilder->buildStockTransaction($input, $itemObject, $stockTransactionObject);
                $this->em->persist($stockTransactionObject);
                $this->em->flush();
                $result["result"] = $stockTransactionObject;
                $result["statusCode"] = Response::HTTP_OK;
                $result["message"] = "SUCCESS";
            }
        }


        return $result;
    }

    public function confirmStockTransaction($id)
    {
        $stockTransactionObject = $this->fetchData('AppBundle:StockTransaction', $id);
        $itemObject = $this->fetchData('AppBundle:Item', $stockTransactionObject->getItemId());

        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function removeStockTransaction($id)
    {


        $stockTransaction = $this->fetchData('AppBundle:StockTransaction', $id);
        if ($stockTransaction) {
            $this->em->remove($stockTransaction);
            $this->em->flush();

            $result["result"] = $stockTransaction;
            $result["statusCode"] = Response::HTTP_OK;
            $result["message"] = "SUCCESS";
            return $result;
        }

        return $result;

    }

}