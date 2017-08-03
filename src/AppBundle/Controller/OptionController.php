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
     * Gets an individual option
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Form",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction(int $id) {
        $option = $this->getOptionRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($option === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $option;
    }

    /**
     * Gets a collection of options
     *
     * @return array
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Form",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction() {
        return $this->getOptionRepository()->createFindAllQuery()->getResult();
    }

    /**
     *
     * Adds an option
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\OptionType",
     *     output="AppBundle\Entity\Form",
     *     statusCodes={
     *         201 = "Returned when a new Option has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {

    }

    /**
     *
     * Updates option
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\OptionType",
     *     output="AppBundle\Entity\Option",
     *     statusCodes={
     *         204 = "Returned when an existing Option has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function putAction(Request $request, int $id) {

    }
//
//    /**
//     *
//     * Updates document
//     *
//     * @param Request $request
//     * @param int     $id
//     * @return View|\Symfony\Component\Form\Form
//     *
//     * @ApiDoc(
//     *     input="AppBundle\Form\Type\DocumentType",
//     *     output="AppBundle\Entity\Document",
//     *     statusCodes={
//     *         204 = "Returned when an existing Document has been successful updated",
//     *         400 = "Return when errors",
//     *         404 = "Return when not found"
//     *     }
//     * )
//     */
//    public function patchAction(Request $request, int $id) {
//        /**
//         * @var $document Document
//         */
//        $document = $this->getDocumentRepository()->find($id);
//        if ($document === null) {
//            return new View(null, Response::HTTP_NOT_FOUND);
//        }
//        $form = $this->createForm(DocumentType::class, $document, [
//            'csrf_protection' => false,
//        ]);
//        $form->submit($request->request->all(), false);
//        if (!$form->isValid()) {
//            return $form;
//        }
//        $em = $this->getDoctrine()->getManager();
//        $em->flush();
//        $routeOptions = [
//            'id' => $document->getId(),
//            '_format' => $request->get('_format'),
//        ];
//        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_NO_CONTENT);
//    }
//
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