<?php
declare(strict_types=1);

namespace App\Service\CriteriaTypes;

use App\Entity\UserSelectedValue;

class InArray implements CriteriaTypeInterface
{
    /**
     * @param UserSelectedValue[] $userSelectedValues
     * @param UserSelectedValue[] $currentUserSelectedValues
     */
    public function execute(array $userSelectedValues, array $currentUserSelectedValues, int $weight): int
    {
    }
}
