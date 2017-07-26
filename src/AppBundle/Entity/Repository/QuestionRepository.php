<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository {

    public function createFindAllQuery() {
        return $this->_em->createQuery("SELECT q FROM AppBundle:Question q");
    }

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT q FROM AppBundle:Question q WHERE q.id = :id");
        $query->setParameter('id', $id);
        return $query;
    }

    public function findByFormIdQuery(int $formId) {
        $query = $this->_em->createQuery("SELECT q FROM AppBundle:Question q WHERE q.form = :id");
        $query->setParameter('id', $formId);
        return $query;
    }    
    
}
