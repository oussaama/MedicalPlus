<?php

namespace Medical\MedicalBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

    public function findByRoles($role) {
        $qb = $this->createQueryBuilder();
        $qb->select('u')
                ->from($this->_entityName, 'u')
                ->where('u.role LIKE :role')
                ->setParameter('role',$role);

        return $qb->getQuery()->getResult();
    }

    public function findBySpeciality($i) {
        $qb = $this->createQueryBuilder();
        $qb->select('s.nom_spec')
            ->from('MedicalMedicalBundle:User u,MedicalMedicalBundle:Specialiste s')
            ->where('u.speciality = s.id')
            ->groupBy('s.nom_spec');

        return $qb->getQuery()->getResult();
    }
    
}