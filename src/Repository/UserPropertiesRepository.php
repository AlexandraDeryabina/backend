<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserPropertiesRepository extends EntityRepository
{

    public function getValuesByType(int $userId): array
    {
        $this->getEntityManager()->createNamedNativeQuery(
            "
            SELECT * FROM user_properties as up
            JOIN user_selected_value AS usv ON usv."
        );
        return $this->createQueryBuilder('c')
            ->join('c.criteriaType', 't')
            ->where('c.user_id = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getArrayResult();
    }
}
