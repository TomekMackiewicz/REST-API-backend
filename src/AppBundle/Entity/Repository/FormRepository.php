<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FormRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT d FROM AppBundle:Form d");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT d FROM AppBundle:Form d WHERE d.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }

}
