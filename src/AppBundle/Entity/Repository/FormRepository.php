<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FormRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT f FROM AppBundle:Form f");
    }

    public function createFindOneByIdQuery(int $id) {       
        $query = $this->_em->createQuery("SELECT f FROM AppBundle:Form f WHERE f.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }

}
