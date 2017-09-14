<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT p FROM AppBundle:Payment p");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT p FROM AppBundle:Payment p WHERE p.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }

}
