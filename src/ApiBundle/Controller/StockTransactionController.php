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
     * @ApiDoc(
     *   resource = true,
     *   section= "Stock Transaction",
     *   description = "Get Stock Transaction List",
     *   views = {"meetup"}
     * )
     *
     *
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
     * @ApiDoc(
     *   resource = true,
     *   section= "Stock Transaction",
     *   description = "Get Stock Transaction Detail",
     *   views = {"meetup"}
     * )
     *
     *
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
     * @ApiDoc(
     *   resource = true,
     *   section= "Stock Transaction",
     *
     *   input={
     *    "class" = "ApiBundle\Form\Type\PostStockTransactionType",
     *    "options" = {"method" = "POST"},
     *    "name" = ""
     *   },
     *   description = "Creates a new sales invoice from the submitted data.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when bad parameters are passed"
     *   },
     *     views = {"meetup"}
     * )
     *
     *
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
     * @ApiDoc(
     *   resource = true,
     *   section= "Stock Transaction",
     *   input={
     *      "class" = "ApiBundle\Form\Type\PutStockTransactionType",
     *      "options" = {"method" = "PUT"},
     *      "name" = ""
     *   },
     *   description = "Update a stock transaction",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * PUT Route annotation.
     * @Put("/stock_transaction")
     * @return \FOS\RestBundle\View\View
     */
    public function putStockTransactionAction(Request $request)
    {
        $input = $request->request->all();
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
     * @ApiDoc(
     *   resource = true,
     *   section= "Stock Transaction",
     *   description = "Delete a stock transaction",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * PUT Route annotation.
     * @Put("/stock_transaction")
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
     * @ApiDoc(
     *   resource = true,
     *   section= "Stock Transaction",
     *   description = "Creates a new sales invoice from the submitted data.",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when bad parameters are passed"
     *   },
     *     views = {"meetup"}
     * )
     *
     *
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
