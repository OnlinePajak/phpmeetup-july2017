<?php
namespace ApiBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use FOS\RestBundle\Util\Codes;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserService
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function fetchUser($id){
        $user = $this->em->getRepository('AppBundle:User')->find($id);
        $result["result"][0]["id"] =  $user->getId();
        $result["result"][0]["name"] =  $user->getName();
        $result["result"][0]["email"] =  $user->getEmail();
        $result["statusCode"] = Response::HTTP_OK;
        return $result;
    }
}