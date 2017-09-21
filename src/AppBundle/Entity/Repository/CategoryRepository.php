<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT c FROM AppBundle:Category c");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT c FROM AppBundle:Category c WHERE c.id = :id");
        $query->setParameter('id', $id);
        return $query;
    }

}
