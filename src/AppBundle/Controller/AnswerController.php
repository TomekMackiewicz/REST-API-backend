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
        $answers = $this->processAnswers($inputAnswers);
        $email = $request->request->get("email");
        $em = $this->getDoctrine()->getManager();
        $form = $em->getRepository('AppBundle:Form')->createFindOneByIdQuery((int) $formId)->getSingleResult();
        $body = $form->getDocument()->getBody();
        $title = $form->getDocument()->getTitle();
        
        foreach($answers as $key => $value) {
            if (is_array($value)) {
                $body = str_replace("[".$key."]", "<strong>".implode(", ",$value)."</strong>", $body);
            } else {
                $body = str_replace("[".$key."]", "<strong>".$value."</strong>", $body);                
            }
        }
        
        $text = new ReadyText();
        $text->setTitle($title);
        $text->setBody($body);
        $text->setEmail($email);
        $em->persist($text);
        $em->flush();        
        
        return View::create()->setStatusCode(201)->setData($text->getId());        

    }
    
    private function processAnswers($inputAnswers) {
        $answers = [];
        foreach ($inputAnswers as $questionId => $inputAnswer) {
            if($questionId === "formId" || $questionId === "email" ) {
                continue;
            } else {
                $answers[$questionId] = $inputAnswer;
            }
        }

        return $answers;
    }
    
    /**
     * @return AnswerRepository
     */
    private function getAnswerRepository() {
        return $this->get('crv.doctrine_entity_repository.answer');
    }

  
    
}


