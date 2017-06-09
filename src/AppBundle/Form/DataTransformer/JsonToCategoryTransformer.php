<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\DocumentCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class JsonToCategoryTransformer implements DataTransformerInterface {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * Transforms an object to a string.
     *
     * @param  DocumentCategory|null $category
     * @return string
     */
    public function transform($category) {
        if (null === $category) {
            return '';
        }
        //return $category->getId();
        return $category->getId();
    }

    /**
     * Transforms a string to an object.
     *
     * @param  string $categoryName
     * @return DocumentCategory|null
     * @throws TransformationFailedException if object (category) is not found.
     */
    public function reverseTransform($categoryName) {
        // no text? It's optional, so that's ok
        if (!$categoryName) {
            return;
        }
        $category = $this->em
                ->getRepository('AppBundle:DocumentCategory')
                // query for the category
                ->findOneByName($categoryName)
        ;
        if (null === $category) {
//            $category = new DocumentCategory();
//            $category->setName($categoryName);
//            $em = $this->manager;
//            $em->persist($category);
//            $em->flush();
            throw new TransformationFailedException(sprintf(
                    'Category with name "%s" does not exist!', $categoryName
            ));
        }
        return $category;
    }

}
