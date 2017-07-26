<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ReadyTextRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT t FROM AppBundle:ReadyText t");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT t FROM AppBundle:ReadyText t WHERE t.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }

}

