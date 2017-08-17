<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ReadyTextRepository extends EntityRepository {

    public function createFindOneByIdQuery($id) {
        $query = $this->_em->createQuery("SELECT t FROM AppBundle:ReadyText t WHERE t.id = :id");
        $query->setParameter('id', $id);

        return $query;
    }

    public function createFindOneByTokenQuery($token) {
        $query = $this->_em->createQuery("SELECT t FROM AppBundle:ReadyText t WHERE t.token = :token");
        $query->setParameter('token', $token);

        return $query;
    }    
    
}

