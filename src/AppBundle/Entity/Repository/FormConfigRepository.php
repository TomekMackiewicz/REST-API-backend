<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FormConfigRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT c FROM AppBundle:FormConfig c");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT c FROM AppBundle:FormConfig c WHERE c.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }

}
