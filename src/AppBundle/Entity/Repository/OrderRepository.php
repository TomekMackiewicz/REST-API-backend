<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT o FROM AppBundle:Order o");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT o FROM AppBundle:Order o WHERE o.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }
}
