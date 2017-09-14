<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class SettingRepository extends EntityRepository {

    public function createFindOneByIdQuery(int $id) {
        $query = $this->_em->createQuery("SELECT s FROM AppBundle:Setting s WHERE s.id = :id");
        $query->setParameter('id', $id);
        return $query;
    }

}
