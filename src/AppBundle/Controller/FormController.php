<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Form;
//use AppBundle\Entity\Question;
use AppBundle\Entity\Repository\FormRepository;
use AppBundle\Form\Type\FormType;
use AppBundle\Form\Type\FormConfigType;
use AppBundle\Form\Type\QuestionType;
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
 * Class FormController
 * @package AppBundle\Controller
 *
 * @RouteResource("form")
 */
class FormController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual form
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
        $form = $this->getFormRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($form === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $form;
    }

    /**
     * Gets a collection of forms
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
        return $this->getFormRepository()->createFindAllQuery()->getResult();
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
        $form = $this->createForm(FormType::class, null, ['csrf_protection' => false]);               
        $form->submit($request->request->all());
        if (!$form->isValid()) { 
            return $form;             
        }
        $uploadedForm = $form->getData();        
        $em = $this->getDoctrine()->getManager(); 
        
        $this->uploadConfig($em, $request->request->get('config'), $uploadedForm);
        $this->uploadQuestions($em, $uploadedForm, $request->request->get('questions'));

        /*
         * Add create date
         */
        //$uploadedForm->set...Date(new \DateTime());
        
        $em->persist($uploadedForm);
        $em->flush();

        $routeOptions = [
            'id' => $uploadedForm->getId(),
            '_format' => $request->get('_format'),
        ];

        return $this->routeRedirectView('get_form', $routeOptions, Response::HTTP_CREATED);
    }

    /**
     *
     * Updates form
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\FormType",
     *     output="AppBundle\Entity\Form",
     *     statusCodes={
     *         204 = "Returned when an existing Form has been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function putAction(Request $request, int $id) {

        $editedForm = $this->getFormRepository()->find($id);
        //$categories = $request->request->get('categories');
        $em = $this->getDoctrine()->getManager();

        if ($editedForm === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(FormType::class, $editedForm, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }

        $editedForm->setModifiedDate(new \DateTime());

//        /*
//         * Delete current relations
//         */
//        $relations = $editedForm->getQuestions();
//        foreach ($relations as $relation) {
//            $editedForm->removeQuestion($relation);
//        }        
        
        $this->uploadConfig($em, $request->request->get('config'), $editedForm);
        $this->uploadQuestions($em, $editedForm, $request->request->get('questions'));

        $em->persist($editedForm);
        $em->flush();

        $routeOptions = [
            'id' => $editedForm->getId(),
            '_format' => $request->get('_format'),
        ];
        return $this->routeRedirectView('get_form', $routeOptions, Response::HTTP_NO_CONTENT);
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
     * Deletes form
     *
     * @param int $id
     * @return View
     *
     * @ApiDoc(
     *     statusCodes={
     *         204 = "Returned when an existing form has been successful deleted",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function deleteAction(int $id) {
        /**
         * @var $form Form
         */
        $form = $this->getFormRepository()->find($id);
        if ($form === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($form);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }

    private function uploadConfig($em, $conf, $f) {
        if(isset($conf["id"])) {
            $editedConfig = $this->getConfigRepository()->find($conf["id"]);
            if ($editedConfig === null) {
                return new View(null, Response::HTTP_NOT_FOUND);
            }      
            $form = $this->createForm(FormConfigType::class, $editedConfig, [
                'csrf_protection' => false,
            ]);
            $form->submit($conf);
            if (!$form->isValid()) {
                return $form;
            } 
            $config = $form->getData();
            $em->persist($config);             
        } else {
            $form = $this->createForm(FormConfigType::class, null, ['csrf_protection' => false]);                       
            $form->submit($conf);
            if (!$form->isValid()) { 
                return $form;             
            }
            $config = $form->getData();        
            $f->addConfig($config);        
            $em->persist($config);             
        }
                      
    }
  
    private function uploadQuestions($em, $f, $questions) {
        foreach($questions as $q) {
            //file_put_contents('/var/www/log.log', $q["id"], true);
            if(isset($q["id"])) {
                //file_put_contents('/var/www/log.log', $q);
                $editedQuestion = $this->getQuestionRepository()->find($q["id"]);
                if ($editedQuestion === null) {
                    return new View(null, Response::HTTP_NOT_FOUND);
                }      
                $form = $this->createForm(QuestionType::class, $editedQuestion, [
                    'csrf_protection' => false,
                ]);           
                $form->submit($q);
                if (!$form->isValid()) { 
                    return $form;                 
                }
                $question = $form->getData();
                //$f->addQuestion($question);
                //$question->addForm($f);
                $em->persist($question);            
                $this->uploadOptions($em, $question, $q["options"]);                
            } else {
                //file_put_contents('/var/www/log.log', $q["name"]);
                $form = $this->createForm(QuestionType::class, null, ['csrf_protection' => false]);            
                $form->submit($q);
                if (!$form->isValid()) { 
                    return $form;                 
                }
                $question = $form->getData();
                $f->addQuestion($question);
                $question->addForm($f);
                $em->persist($question);            
                $this->uploadOptions($em, $question, $q["options"]);                
            }       
        }        
    }
    
    private function uploadOptions($em, $question, $options) {
        foreach($options as $opt) {
            if(isset($opt["id"])) {
                $editedOption = $this->getOptionRepository()->find($opt["id"]);
                if ($editedOption === null) {
                    return new View(null, Response::HTTP_NOT_FOUND);
                }      
                $form = $this->createForm(OptionType::class, $editedOption, [
                    'csrf_protection' => false,
                ]);           
                $form->submit($opt);
                if (!$form->isValid()) { 
                    return $form;                 
                }
                $option = $form->getData();
                //$f->addQuestion($question);
                //$question->addForm($f);
                $em->persist($option);                
            } else {
                $form = $this->createForm(OptionType::class, null, ['csrf_protection' => false]);            
                $form->submit($opt);
                if (!$form->isValid()) {
                    return $form;                 
                }
                $option = $form->getData();
                $question->addOption($option);
                $option->addQuestion($question);
                $em->persist($option);                
            }                
        }        
    }
    
    /**
     * @return FormRepository
     */
    private function getFormRepository() {
        return $this->get('crv.doctrine_entity_repository.form');
    }

    /**
     * @return ConfigRepository
     */
    private function getConfigRepository() {
        return $this->get('crv.doctrine_entity_repository.config');
    }    

    /**
     * @return QuestionRepository
     */
    private function getQuestionRepository() {
        return $this->get('crv.doctrine_entity_repository.question');
    }  

    /**
     * @return OptionRepository
     */
    private function getOptionRepository() {
        return $this->get('crv.doctrine_entity_repository.option');
    }
    
}

