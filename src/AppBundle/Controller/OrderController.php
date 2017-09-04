<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Order;
use AppBundle\Form\Type\OrderType;
use AppBundle\Entity\Repository\OrderRepository;
//use FOS\RestBundle\View\View;
//use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use FOS\RestBundle\Controller\Annotations\View AS JSONView;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use FOS\RestBundle\View\View;

/**
 * Class OrderController
 * @package AppBundle\Controller
 *
 * @RouteResource("order")
 */
class OrderController extends FOSRestController implements ClassResourceInterface
{

    /**
     * Gets individual order
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction(int $id) {
        $order = $this->getOrderRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($order === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $order;
    }    

    /**
     * Gets orders
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction() {
        return $this->getOrderRepository()->createFindAllQuery()->getResult();
    } 
    
    /**
     * Posts an order
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(OrderType::class, null, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
        $order = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        return View::create()->setStatusCode(201)->setData($order->getId()); 
//        $routeOptions = [
//            'id' => $order->getId(),
//            '_format' => $request->get('_format'),
//        ];
//
//        return $this->routeRedirectView('get_orders', $routeOptions, Response::HTTP_CREATED);
    }    

    /**
     * Shows order
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Order",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     * @Get("/orders/{id}/show")
     */    
    public function showAction(Request $request, Order $order)
    {
        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $order->getAmount(),
            'currency' => 'EUR',
        ]);


//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $ppc = $this->get('payment.plugin_controller');
//            $ppc->createPaymentInstruction($instruction = $form->getData());
//
//            $order->setPaymentInstruction($instruction);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($order);
//            $em->flush($order);
//
//            return $this->redirect($this->generateUrl('app_orders_paymentcreate', [
//                'id' => $order->getId(),
//            ]));
//        }        
        
        return [
            'order' => $order,
            'form'  => $form->createView(),
        ];
    }    
    
    /**
     * @return OrderRepository
     */
    private function getOrderRepository() {
        return $this->get('crv.doctrine_entity_repository.order');
    }
    
}
