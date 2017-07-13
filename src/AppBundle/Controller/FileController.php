<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Routing\ClassResourceInterface;

class FileController extends Controller implements ClassResourceInterface
{
    public function postAction(Request $request)
    { 
        $uploadHandler = $this->get('srio_rest_upload.upload_handler');
        $result = $uploadHandler->handleRequest($request);

        if (($response = $result->getResponse()) !== null) {
            return $response;
        }

        if (($file = $result->getFile()) !== null) {
            // Store the file path in an entity, call an API,
            // do whatever with the uploaded file here.

            return new Response();
        }

        throw new BadRequestHttpException('Unable to handle upload request');
        
//        //$form = $this->createForm(new FileFormType());
//        $form = $this->createForm(FileFormType::class, $request);
//        /** @var $uploadHandler UploadHandler */
//        $uploadHandler = $this->get('srio_rest_upload.upload_handler');
//        $result = $uploadHandler->handleRequest($request, $form);
//
//        if (($response = $result->getResponse()) != null) {
//            return $response;
//        }
//
//        if (!$form->isValid()) {
//            throw new BadRequestHttpException();
//        }
//
//        if (($file = $result->getFile()) !== null) {
//            /** @var $media Media */
//            $media = $form->getData();
//            $media->setFile($file);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($media);
//            $em->flush();
//
//            return new JsonResponse($media);
//        }
//
//        throw new NotAcceptableHttpException();
    }
}
