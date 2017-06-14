<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DocumentCategory;
use AppBundle\Entity\Repository\DocumentCategoryRepository;
use AppBundle\Form\Type\DocumentCategoryType;
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
use FOS\RestBundle\Controller\Annotations\View AS JSONView;

/**
 * Class DocumentCategoryController
 * @package AppBundle\Controller
 *
 * @RouteResource("category")
 */
class DocumentCategoryController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual category
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\DocumentCategory",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     * @JSONView(serializerEnableMaxDepthChecks=true)
     */
    public function getAction(int $id) {
        $category = $this->getDocumentCategoryRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $category;
    }

    /**
     * Gets a collection of categories
     *
     * @return array
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\DocumentCategory",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction() {
        return $this->getDocumentCategoryRepository()->createFindAllQuery()->getResult();
    }

    /**
     *
     * Adds a category
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\DocumentCategoryType",
     *     output="AppBundle\Entity\DocumentCategory",
     *     statusCodes={
     *         201 = "Returned when a new DocumentCategory has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {
        $form = $this->createForm(DocumentCategoryType::class, null, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
        /**
         * @var $category DocumentCategory
         */
        $category = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        $routeOptions = [
            'id' => $category->getId(),
            '_format' => $request->get('_format'),
        ];

        return $this->routeRedirectView('get_category', $routeOptions, Response::HTTP_CREATED);
    }

    /**
     *
     * Updates category
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\DocumentCategoryType",
     *     output="AppBundle\Entity\DocumentCategory",
     *     statusCodes={
     *         204 = "Returned when an existing DocumentCategory has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function putAction(Request $request, int $id) {
        /**
         * @var $category DocumentCategory
         */
        $category = $this->getDocumentCategoryRepository()->find($id);
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DocumentCategoryType::class, $category, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $routeOptions = [
            'id' => $category->getId(),
            '_format' => $request->get('_format'),
        ];
        return $this->routeRedirectView('get_category', $routeOptions, Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * Updates category
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\DocumentCategoryType",
     *     output="AppBundle\Entity\DocumentCategoryPost",
     *     statusCodes={
     *         204 = "Returned when an existing DocumentCategory has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function patchAction(Request $request, int $id) {
        /**
         * @var $category DocumentCategory
         */
        $category = $this->getDocumentCategoryRepository()->find($id);
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DocumentCategoryType::class, $category, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all(), false);
        if (!$form->isValid()) {
            return $form;
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $routeOptions = [
            'id' => $category->getId(),
            '_format' => $request->get('_format'),
        ];
        return $this->routeRedirectView('get_category', $routeOptions, Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * Deletes category
     *
     * @param int $id
     * @return View
     *
     * @ApiDoc(
     *     statusCodes={
     *         204 = "Returned when an existing DocumentCategory has been successful deleted",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function deleteAction(int $id) {
        /**
         * @var $category DocumentCategory
         */
        $category = $this->getDocumentCategoryRepository()->find($id);
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return DocumentCategoryRepository
     */
    private function getDocumentCategoryRepository() {
        return $this->get('crv.doctrine_entity_repository.document_category');
    }

}
