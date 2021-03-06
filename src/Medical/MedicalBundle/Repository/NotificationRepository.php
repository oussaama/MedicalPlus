<?php

namespace Medical\MedicalBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository {
    
    public function findBy($exp){
        $qb=$this->createQueryBuilder();
        $qb->select('u')
           ->Where('u.destinateur ='.$exp)
           ->orderBy('u.date_not','DESC');
        
        return $qb->getQuery()->getResult();
    }
    
}
