<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\ReadyText;
use AppBundle\Entity\Repository\AnswerRepository;
use AppBundle\Form\Type\AnswerType;
use AppBundle\Form\Type\ReadyTextType;
use AppBundle\Form\Type\FormConfigType;
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
 * Class AnswerController
 * @package AppBundle\Controller
 *
 * @RouteResource("answer")
 */
class AnswerController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual answer
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
     * @JSONView(serializerEnableMaxDepthChecks=true)
     */
    public function getAction(int $id) {
        $answer = $this->getAnswerRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($answer === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $answer;
    }

    /**
     * Gets a collection of answers
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
     * @JSONView(serializerEnableMaxDepthChecks=true)
     */
    public function cgetAction() {
        return $this->getAnswerRepository()->createFindAllQuery()->getResult();
    }

    /**
     *
     * Adds a form
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\FormType",
     *     output="AppBundle\Entity\Form",
     *     statusCodes={
     *         201 = "Returned when a new Form has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {       
        $inputAnswers = json_decode($request->getContent());
        $formId = $request->request->get("formId");
        $em = $this->getDoctrine()->getManager();
        $answers = [];
        foreach ($inputAnswers as $questionId => $inputAnswer) {
            if($questionId === "formId") {
                continue;
            } elseif(is_array($inputAnswer)) {
                foreach ($inputAnswer as $inputOption) {
                    $answers[$questionId] = $inputOption;
                    $form = $this->createForm(AnswerType::class, null, ['csrf_protection' => false]); 
                    $answer = array("formId" => $formId, "body" => $inputOption);
                    $form->submit($answer);
                    if (!$form->isValid()) { 
                        return $form;             
                    }                
                    $outputAnswer = $form->getData(); 
                    $em->persist($outputAnswer);
                    $em->flush();                    
                }
            } else { 
                $answers[$questionId] = $inputAnswer;
                $form = $this->createForm(AnswerType::class, null, ['csrf_protection' => false]); 
                $answer = array("formId" => $formId, "body" => $inputAnswer);
                $form->submit($answer);
                if (!$form->isValid()) { 
                    return $form;             
                }                
                $outputAnswer = $form->getData();
                $em->persist($outputAnswer);
                $em->flush();                
            }
//            $em->persist($outputAnswer);
//            $em->flush();
        }
        
        $this->processDocument($formId, $answers);
        
        $routeOptions = [
            'id' => $outputAnswer->getId(),
            '_format' => $request->get('_format'),
        ];

        return $this->routeRedirectView('get_form', $routeOptions, Response::HTTP_CREATED);
    }

    private function processDocument($formId, $answers) {
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('AppBundle:Document')->findByFormId((int) $formId)->getSingleResult();
        $t = $document->getBody();

        foreach($answers as $key => $value) {
            // Nie działa checkbox
            $t = str_replace("[".$key."]", "<strong>".$value."</strong>", $t);
//            if (is_array($value)) {
//                file_put_contents('/home/tomek/Workspace/log.log', 'true');
//                $text = str_replace("[".$key."]", implode(',', $value), $text);
//            }
        }
        //file_put_contents('/home/tomek/Workspace/log.log', $text);
        $title = $document->getTitle();
        $body = $t;
        $text = new ReadyText();
        $text->setTitle($title);
        $text->setBody($body);
        $em->persist($text);
        $em->flush();        
        //$this->saveText($text);
    }
    
//        $routeOptions = [
//            'id' => $document->getId(),
//            '_format' => $request->get('_format'),
//        ];
//
//        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_CREATED);        
//    }
    
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
//    public function putAction(Request $request, int $id) {
//
//        $document = $this->getDocumentRepository()->find($id);
//        $categories = $request->request->get('categories');
//        $em = $this->getDoctrine()->getManager();
//
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
//
//        /*
//         * Add modify data
//         */
//        $document->setModifiedDate(new \DateTime());
//
//        /*
//         * First we delete current relations
//         */
//        $relations = $document->getCategories();
//        foreach ($relations as $relation) {
//            $document->getCategories()->removeElement($relation);
//        }
//
//        /*
//         * Then we loop thru current categories
//         */
//        foreach ($categories as $categoryId) {
//            $category = $em->getRepository('AppBundle:DocumentCategory')->find((int) $categoryId['id']);
//            /*
//             * We add new relations only if relation does not exist - to avoid duplicates
//             */
//            if (!$category->hasDocument($document)) {
//                $category->addDocument($document);
//            }
//            if (!$document->hasCategory($category)) {
//                $document->addCategory($category);
//            }
//            $em->persist($category);
//        }
//
//        $em->flush();
//
//        $routeOptions = [
//            'id' => $document->getId(),
//            '_format' => $request->get('_format'),
//        ];
//        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_NO_CONTENT);
//    }
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
//    /**
//     *
//     * Deletes document
//     *
//     * @param int $id
//     * @return View
//     *
//     * @ApiDoc(
//     *     statusCodes={
//     *         204 = "Returned when an existing Document has been successful deleted",
//     *         404 = "Return when not found"
//     *     }
//     * )
//     */
//    public function deleteAction(int $id) {
//        /**
//         * @var $document Document
//         */
//        $document = $this->getDocumentRepository()->find($id);
//        if ($document === null) {
//            return new View(null, Response::HTTP_NOT_FOUND);
//        }
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($document);
//        $em->flush();
//
//        return new View(null, Response::HTTP_NO_CONTENT);
//    }
   
    /**
     * @return AnswerRepository
     */
    private function getAnswerRepository() {
        return $this->get('crv.doctrine_entity_repository.answer');
    }

  
    
}


