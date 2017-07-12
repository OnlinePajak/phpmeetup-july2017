<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;


/**
 * @\FOS\RestBundle\Controller\Annotations\Route("/api")
 */
class UserController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   section= "User Profile",
     *   description = "Get User information",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * Get Route annotation.
     * @Get("/existed_user/{id}")
     * @return \FOS\RestBundle\View\View
     */
    public function getUserAction($id)
    {

        try {
            $response = $this->get('meetup.api.user')->fetchUser($id);
            $statusCode = $response["statusCode"];
        } catch (Exception $e) {

            if($e->getMessage()!=null){
                $response['message'] = $e->getMessage();
            }
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        return new Response(json_encode($response));
    }
}
