<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Order;
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
        $em = $this->getDoctrine()->getManager();

        $order = new Order($request);
        $em->persist($order);
        $em->flush();

        return $this->redirect($this->generateUrl('app_orders_show', [
            'id' => $order->getId(),
        ]));
    }    

    /**
     * @return OrderRepository
     */
    private function getOrderRepository() {
        return $this->get('crv.doctrine_entity_repository.order');
    }
    
}
