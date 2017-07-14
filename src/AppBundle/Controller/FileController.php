<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Finder\Finder;
//use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class FileController extends Controller implements ClassResourceInterface
{
    
    public function cgetAction() 
    {
        $finder = new Finder();
        $finder->files()->in('/var/www/rest-api/REST-API-backend/web/uploads');
        //$root1 = $this->container->get('app.root.service');
        //$root2 = $root1->getProjectDir();
        //$finder->directories()->in(__DIR__);
        
        $files = [];
        
        foreach ($finder as $file) {
            $files[] = $file->getRelativePathname();
            // Dump the absolute path
            //var_dump($file->getRealPath());
            //file_put_contents('/var/www/log.log', $file->getRealPath());

            // Dump the relative path to the file, omitting the filename
            //var_dump($file->getRelativePath());

            // Dump the relative path to the file
            //var_dump($file->getRelativePathname());
        }
        
        return $files;
    }    
    
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
    
    public function deleteAction(string $name) 
    {

        $fs = new Filesystem();

        try {
            $fs->remove(array('file', '/var/www/rest-api/REST-API-backend/web/uploads/'.$name, $name));
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while deleting file at ".$e->getPath();
        }
        
    }    
    
}
