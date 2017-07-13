<?php

namespace ApiBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * @\FOS\RestBundle\Controller\Annotations\Route("/api")
 */
class StockTransactionController extends FOSRestController
{
    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * Get Route annotation.
     * @Get("/stock_transaction/list")
     */
    public function getStockTransactionListAction()
    {
        try {
            $response = $this->get('meetup.api.stock_transaction')->fetchStockTransactionList();
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }

        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }

    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * Get Route annotation.
     * @Get("/stock_transaction/{id}")
     * @return \FOS\RestBundle\View\View
     */
    public function getStockTransactionDetailAction($id)
    {
        try {
            $response = $this->get('meetup.api.stock_transaction')->fetchStockTransactionDetail($id);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }

        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }


    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * POST Route annotation.
     * @Post("/stock_transaction")
     */
    public function postStockTransactionAction(Request $request)
    {
        $input = $request->request->all();
        try {
            $response = $this->get('meetup.api.stock_transaction')->createStockTransaction($input);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }
        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }

    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * PUT Route annotation.
     * @Put("/stock_transaction")
     */
    public function putStockTransactionAction(Request $request)
    {
        $input = $request->request->all();

        var_dump($input);exit;

        try {
            $response = $this->get('meetup.api.stock_transaction')->updateStockTransaction($input);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }

        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }

    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * PUT Route annotation.
     * @Put("/stock_transaction/confirm/{id}")
     * @return \FOS\RestBundle\View\View
     */
    public function putStockConfirmationAction($id)
    {
        try {
            $response = $this->get('meetup.api.stock_transaction')->confirmStockTransaction($id);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }

        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }

    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * DELETE Route annotation.
     * @Delete("/stock_transaction/{id}")
     */
    public function DeleteStockTransactionAction($id)
    {
        try {
            $response = $this->get('meetup.api.stock_transaction')->removeStockTransaction($id);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }

        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }
}
