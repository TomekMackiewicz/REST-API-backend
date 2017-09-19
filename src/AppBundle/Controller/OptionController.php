<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Option;
use AppBundle\Entity\Repository\OptionRepository;
use AppBundle\Form\Type\OptionType;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View AS JSONView;

/**
 * Class OptionController
 * @package AppBundle\Controller
 *
 * @RouteResource("option")
 */
class OptionController extends FOSRestController implements ClassResourceInterface {

    /**
     *
     * Deletes option
     *
     * @param int $id
     * @return View
     *
     * @ApiDoc(
     *     statusCodes={
     *         204 = "Returned when an existing option has been successful deleted",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function deleteAction(int $id) {
        /**
         * @var $option Option
         */
        $option = $this->getOptionRepository()->find($id);
        if ($option === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($option);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    } 

    /**
     * @return OptionRepository
     */
    private function getOptionRepository() {
        return $this->get('crv.doctrine_entity_repository.option');
    }  
    
}