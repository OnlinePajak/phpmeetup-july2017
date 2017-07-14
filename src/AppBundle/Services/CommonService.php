<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 07/07/2017
 * Time: 16.25
 */

namespace AppBundle\Services;

use AppBundle\Entity\Item;
use AppBundle\Entity\StockTransaction;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommonService
{
    private $em;

    private $serializer;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return StockTransaction
     */
    public function fetchStockTransactionObject($id = null)
    {
        if ($id) {
            $result = $this->em->getRepository('AppBundle:StockTransaction')->find($id);
        } else {
            $result = $this->em->getRepository('AppBundle:StockTransaction')->findAll();
        }

        return $result;
    }

    /**
     * @return Item
     */
    public function fetchItemObject($id = null)
    {
        if ($id) {
            $result = $this->em->getRepository('AppBundle:Item')->find($id);
        } else {
            $result = $this->em->getRepository('AppBundle:Item')->findAll();
        }

        return $result;
    }

    /**
     * @return User
     */
    public function fetchUserObject($id = null)
    {
        if ($id) {
            $result = $this->em->getRepository('AppBundle:User')->find($id);
        } else {
            $result = $this->em->getRepository('AppBundle:User')->findAll();
        }

        return $result;
    }

    public function setPredefinedResult(){
        $result["result"] = null;
        $result["statusCode"] = Response::HTTP_BAD_REQUEST;
        $result["message"] = "Data is not existed";
        return $result;
    }

    public function setResult($val)
    {
        if(is_array($val)){
            if(count($val) > 0){
                foreach ($val as $item) {
                    $result["data"][] = $item;
                }
            }
        }else{
            $result["data"][0] = $val;
        }

        $result["statusCode"] = Response::HTTP_OK;
        $result["message"] = "SUCCESS";
        return $result;
    }

    public function setFailedResult($message)
    {
        $result["result"] = null;
        $result["statusCode"] = Response::HTTP_BAD_REQUEST;
        $result["message"] = $message;
        return $result;
    }
}