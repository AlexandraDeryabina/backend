<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Criteria;
use Doctrine\ORM\EntityRepository;

class CriteriaRepository extends EntityRepository
{
    /**
     * @return Criteria[]
     */
    public function getCriteriasByType(int $typeId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.criteriaType', 't')
            ->where('t.id = :type_id')
            ->setParameter('type_id', $typeId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Criteria[]
     */
    public function getCriteriasByGroup(int $groupId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.group', 'g')
            ->where('g.id = :group_id')
            ->setParameter('group_id', $groupId)
            ->getQuery()
            ->getResult();
    }
}
