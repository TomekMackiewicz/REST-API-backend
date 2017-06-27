<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Upload;
//use AppBundle\Entity\Repository\FileRepository;
use AppBundle\Form\Type\UploadType;
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
 * Class UploadController
 * @package AppBundle\Controller
 *
 * @RouteResource("upload")
 */
class UploadController extends FOSRestController implements ClassResourceInterface {

    /**
     *
     * Adds a file
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\UploadType",
     *     output="AppBundle\Entity\Upload",
     *     statusCodes={
     *         201 = "Returned when a new File has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function postAction(Request $request) {
        file_put_contents('/home/tomek/Workspace/log.log', $request);
        $form = $this->createForm(UploadType::class, null, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->getDoctrine()->getManager();
        $file = $form->getData();

        $em->persist($file);
        $em->flush();

//        $routeOptions = [
//            'id' => $file->getId(),
//            '_format' => $request->get('_format'),
//        ];
//
//        return $this->routeRedirectView('get_document', $routeOptions, Response::HTTP_CREATED);
    }

}

