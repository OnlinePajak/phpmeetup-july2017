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
class TransactionController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   section= "Transaction",
     *   description = "Get Transaction List",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * Get Route annotation.
     * @Get("/transaction/list")
     */
    public function getTransactionListAction()
    {
        try {
            $response = $this->get('meetup.api.transaction')->fetchTransactionList();
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
     *   section= "Transaction",
     *   description = "Get Transaction Detail",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * Get Route annotation.
     * @Get("/transaction/{id}")
     * @return \FOS\RestBundle\View\View
     */
    public function getTransactionDetailAction($id)
    {
        try {
            $response = $this->get('meetup.api.transaction')->fetchTransactionDetail($id);
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
     *   section= "Transaction",
     *
     *   input={
     *    "class" = "ApiBundle\Form\Type\PostTransactionType",
     *    "options" = {"method" = "POST"},
     *    "name" = ""
     *   },
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
     * @Post("/transaction")
     */
    public function postTransactionAction(Request $request)
    {
        $input = $request->request->all();
        try {
            $response = $this->get('meetup.api.transaction')->createTransaction($input);
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
     *   section= "Transaction",
     *   input={
     *      "class" = "ApiBundle\Form\Type\PutTransactionType",
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
     * @Put("/transaction")
     * @return \FOS\RestBundle\View\View
     */
    public function putTransactionAction(Request $request)
    {
        $input = $request->request->all();
        try {
            $response = $this->get('meetup.api.transaction')->updateTransaction($input);
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
     *   section= "Transaction",
     *   description = "Delete a stock transaction",
     *   views = {"meetup"}
     * )
     *
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * PUT Route annotation.
     * @Put("/transaction")
     * @return \FOS\RestBundle\View\View
     */
    public function putStockConfirmationAction($id)
    {
        try {
            $response = $this->get('meetup.api.transaction')->confirmTransaction($id);
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
     *   section= "Transaction",
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
     * @Delete("/transaction/{id}")
     */
    public function DeleteTransactionAction($id)
    {
        try {
            $response = $this->get('meetup.api.transaction')->removeTransaction($id);
        } catch (Exception $e) {
            if($e->getMessage()!=null){
                $response['result'] = $e->getMessage();
                $response["statusCode"] = Response::HTTP_BAD_REQUEST;
            }
        }

        return new Response($this->container->get('jms_serializer')->serialize($response, 'json'));
    }
}
