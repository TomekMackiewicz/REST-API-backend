<?php

namespace AppBundle\Services;

use SRIO\RestUploadBundle\Upload\UploadContext;
use SRIO\RestUploadBundle\Strategy\NamingStrategy;

class ImageNamingService implements NamingStrategy
{
    const DEFAULT_EXTENSION = 'jpg';
    //const DEFAULT_EXTENSION = 'docx';
    //const DEFAULT_EXTENSION = 'txt';

    /**
     * {@inheritdoc}
     */
    public function getName(UploadContext $context)
    {
        // 500 if name already exists - to fix, random name = uncomment
        
        //$name = uniqid();
        //$extension = self::DEFAULT_EXTENSION;

        if (($request = $context->getRequest()) !== null) {
            $files = $request->files->all();

            /** @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
            $file = array_pop($files);

            if ($file !== null) {
                return $file->getClientOriginalName();
                //$parts = explode('.', $file->getClientOriginalName());
                //$extension = array_pop($parts);
            }
        }

        //return $name.'.'.$extension;
    }
}
