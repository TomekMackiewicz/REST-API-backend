<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Entity\Repository\QuestionRepository;
use AppBundle\Form\Type\QuestionType;
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
 * Class QuestionController
 * @package AppBundle\Controller
 *
 * @RouteResource("question")
 */
class QuestionController extends FOSRestController implements ClassResourceInterface {

    /**
     *
     * Deletes question
     *
     * @param int $id
     * @return View
     *
     * @ApiDoc(
     *     statusCodes={
     *         204 = "Returned when an existing question has been successful deleted",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function deleteAction(int $id) {
        /**
         * @var $question Question
         */
        $question = $this->getQuestionRepository()->find($id);
        if ($question === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    } 

    /**
     * @return QuestionRepository
     */
    private function getQuestionRepository() {
        return $this->get('crv.doctrine_entity_repository.question');
    }  
    
}


