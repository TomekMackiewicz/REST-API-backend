<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ReadyText;
use AppBundle\Entity\Repository\ReadyTextRepository;
use AppBundle\Form\Type\ReadyTextType;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View AS JSONView;

/**
 * Class ReadyTextController
 * @package AppBundle\Controller
 *
 * @RouteResource("text")
 */
class ReadyTextController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual text
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\ReadyText",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction(int $id) {
        $text = $this->getReadyTextRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($text === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $text;
    }

    /**
     * @return ReadyTextRepository
     */
    private function getReadyTextRepository() {
        return $this->get('crv.doctrine_entity_repository.readyText');
    }

}

