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
        try{
            $user = $this->em->getRepository('AppBundle:User')->find($id);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['message'] = $e->getMessage();

                $statusCode = Codes::HTTP_BAD_REQUEST;

                return  $this->view($response,$statusCode);
            }
        }
        return array("message" => "success", "user" => $user, "statusCode" => Response::HTTP_OK);
    }
}