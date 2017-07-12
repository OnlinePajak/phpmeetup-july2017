<?php

namespace ApiBundle\Controller;

use Doctrine\Common\Util\Debug;
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
class ItemController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   section= "Items",
     *   description = "Get Product Items",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * Get Route annotation.
     * @Get("/items")
     * @return \FOS\RestBundle\View\View
     */
    public function getItemsAction()
    {
        try {
            $response = $this->get('meetup.api.item')->fetchAllItems();
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }
        return new Response(json_encode($response));
    }
}
