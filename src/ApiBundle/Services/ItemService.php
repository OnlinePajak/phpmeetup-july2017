<?php
/**
 * Created by PhpStorm.
 * User: Ardi
 * Date: 07/07/2017
 * Time: 16.53
 */

namespace ApiBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemService
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function fetchAllItems(){
        $items = $this->em->getRepository('AppBundle:Item')->findAll();
        $result["result"] = $items;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }

    public function fetchItem($id){
        $item = $this->em->getRepository('AppBundle:Item')->find($id);
        $result["result"] = $item;
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }
}