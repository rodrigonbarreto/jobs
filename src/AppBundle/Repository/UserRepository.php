<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package AppBundle\Repository
 */
class UserRepository extends EntityRepository
{


    /**
     * @return mixed
     */
    public function getAllOrderByEmail()
    {
        return $this->createQueryBuilder('user')

            ->orderBy('user.email', 'DESC')
            ->getQuery()
            ->execute();
    }
}
