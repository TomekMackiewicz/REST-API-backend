<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class DocumentRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT d FROM AppBundle:Document d");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT d FROM AppBundle:Document d WHERE d.id = :id");
        $query->setParameter('id', $id);
        return $query;
    }

}
