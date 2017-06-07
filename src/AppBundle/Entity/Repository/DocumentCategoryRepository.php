<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DocumentCategoryRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT dc FROM AppBundle:DocumentCategory dc");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT dc FROM AppBundle:DocumentCategory dc WHERE dc.id = :id");
        $query->setParameter('id', $id);
        return $query;
    }

}
