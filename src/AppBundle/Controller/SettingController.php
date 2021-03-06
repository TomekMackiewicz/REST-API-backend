<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Setting;
use AppBundle\Entity\Repository\SettingRepository;
use AppBundle\Form\Type\SettingType; // ?
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface; // ?
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations\View AS JSONView;

/**
 * Class SettingController
 * @package AppBundle\Controller
 *
 * @RouteResource("setting")
 */
class SettingController extends FOSRestController implements ClassResourceInterface {

    /**
     * Gets an individual setting
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\Setting",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function getAction(int $id) {
        $setting = $this->getSettingRepository()->createFindOneByIdQuery($id)->getSingleResult();
        if ($setting === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        return $setting;
    }

    /**
     *
     * Updates settings
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="AppBundle\Form\Type\SettingType",
     *     output="AppBundle\Entity\Setting",
     *     statusCodes={
     *         204 = "Returned when settings had been successful updated",
     *         400 = "Return when errors",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function putAction(Request $request, int $id) {        
        $settings = $this->getSettingRepository()->find($id);
        $em = $this->getDoctrine()->getManager();
        if ($settings === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(SettingType::class, $settings, [
            'csrf_protection' => false,
        ]);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
        $em->persist($settings);
        $em->flush();
        $routeOptions = [
            'id' => $settings->getId(),
            '_format' => $request->get('_format'),
        ];
        
        return $this->routeRedirectView('get_form', $routeOptions, Response::HTTP_NO_CONTENT);        
    }

    /**
     * @return SettingRepository
     */
    private function getSettingRepository() {
        return $this->get('crv.doctrine_entity_repository.setting');
    }

}

