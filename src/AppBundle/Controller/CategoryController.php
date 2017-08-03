<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Repository\CategoryRepository;
use AppBundle\Form\Type\CategoryType;
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
 * Class CategoryController
 * @package AppBundle\Controller
 *
 * @RouteResource("category")
 */
class CategoryController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual category
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Category",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     * @JSONView(serializerEnableMaxDepthChecks=true)
     */
    public function getAction(int $id) {
        $category = $this->getCategoryRepository()->createFindOneByIdQuery($id)->getSingleResult();
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
     *     output="AppBundle\Entity\Category",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     * @JSONView(serializerEnableMaxDepthChecks=true)
     */
    public function cgetAction() {
        return $this->getCategoryRepository()->createFindAllQuery()->getResult();
    }

    /**
     *
     * Adds a category
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\CategoryType",
     *     output="AppBundle\Entity\Category",
     *     statusCodes={
     *         201 = "Returned when a new Category has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {
        $form = $this->createForm(CategoryType::class, null, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
        /**
         * @var $category Category
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
     *     input="AppBundle\Form\Type\CategoryType",
     *     output="AppBundle\Entity\Category",
     *     statusCodes={
     *         204 = "Returned when an existing Category has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function putAction(Request $request, int $id) {
        /**
         * @var $category Category
         */
        $category = $this->getCategoryRepository()->find($id);
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(CategoryType::class, $category, [
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
     *     input="AppBundle\Form\Type\CategoryType",
     *     output="AppBundle\Entity\CategoryPost",
     *     statusCodes={
     *         204 = "Returned when an existing Category has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function patchAction(Request $request, int $id) {
        /**
         * @var $category Category
         */
        $category = $this->getCategoryRepository()->find($id);
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(CategoryType::class, $category, [
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
     *         204 = "Returned when an existing Category has been successful deleted",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function deleteAction(int $id) {
        /**
         * @var $category Category
         */
        $category = $this->getCategoryRepository()->find($id);
        if ($category === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return CategoryRepository
     */
    private function getCategoryRepository() {
        return $this->get('crv.doctrine_entity_repository.category');
    }

}
