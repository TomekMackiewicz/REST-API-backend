<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Entity\DocumentCategory;
use AppBundle\Entity\Repository\DocumentRepository;
use AppBundle\Form\Type\DocumentType;
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

/**
 * Class DocumentController
 * @package AppBundle\Controller
 *
 * @RouteResource("document")
 */
class DocumentController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual document
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Document",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction(int $id) {
        $document = $this->getDocumentRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($document === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $document;
    }

    /**
     * Gets a collection of documents
     *
     * @return array
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Document",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction() {
        return $this->getDocumentRepository()->createFindAllQuery()->getResult();
    }

    /**
     *
     * Adds a document
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\DocumentType",
     *     output="AppBundle\Entity\Document",
     *     statusCodes={
     *         201 = "Returned when a new Document has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {               
        $form = $this->createForm(DocumentType::class, null, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->getDoctrine()->getManager();
        $document = $form->getData();
        $categories = $request->request->get('categories'); 
        
        foreach ($categories as $categoryId) {
            $category = $em->getRepository('AppBundle:DocumentCategory')->find((int)$categoryId['id']);
            $category->addDocument($document);
            $document->addCategory($category);
            $em->persist($category);            
        }
        
        $em->persist($document);
        $em->flush();
        
        $routeOptions = [
            'id' => $document->getId(),
            '_format' => $request->get('_format'),
        ];

        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_CREATED);
    }

    /**
     *
     * Updates document
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\DocumentType",
     *     output="AppBundle\Entity\Document",
     *     statusCodes={
     *         204 = "Returned when an existing Document has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function putAction(Request $request, int $id) {

        file_put_contents("/home/tomek/Workspace/log.log", $request);       
        
//        $document = $this->getDocumentRepository()->find($id);
//        $categories = $request->request->get('categories');
//        if ($document === null) {
//            return new View(null, Response::HTTP_NOT_FOUND);
//        }
//        $form = $this->createForm(DocumentType::class, $document, [
//            'csrf_protection' => false,
//        ]);
//        $form->submit($request->request->all());
//        if (!$form->isValid()) {
//            return $form;
//        }
//        $document->setModifiedDate(new \DateTime());
//        $em = $this->getDoctrine()->getManager();
//        
//        foreach ($categories as $categoryId) {
//            $category = $em->getRepository('AppBundle:DocumentCategory')->find((int)$categoryId['id']);
//            
//            if (!$category->hasDocument($document)) {
//                $category->addDocument($document);
//            }            
//            if (!$document->hasCategory($category)) {
//                $document->addCategory($category);
//            }             
//            //$category->addDocument($document);
//            //$document->addCategory($category);
//            $em->persist($category);            
//        }        
//        
//        $em->flush();
//        $routeOptions = [
//            'id' => $document->getId(),
//            '_format' => $request->get('_format'),
//        ];
//        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * Updates document
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\DocumentType",
     *     output="AppBundle\Entity\Document",
     *     statusCodes={
     *         204 = "Returned when an existing Document has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function patchAction(Request $request, int $id) {
        /**
         * @var $document Document
         */
        $document = $this->getDocumentRepository()->find($id);
        if ($document === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DocumentType::class, $document, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all(), false);
        if (!$form->isValid()) {
            return $form;
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $routeOptions = [
            'id' => $document->getId(),
            '_format' => $request->get('_format'),
        ];
        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * Deletes document
     *
     * @param int $id
     * @return View
     *
     * @ApiDoc(
     *     statusCodes={
     *         204 = "Returned when an existing Document has been successful deleted",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function deleteAction(int $id) {
        /**
         * @var $document Document
         */
        $document = $this->getDocumentRepository()->find($id);
        if ($document === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($document);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @return DocumentRepository
     */
    private function getDocumentRepository() {
        return $this->get('crv.doctrine_entity_repository.document');
    }

}
