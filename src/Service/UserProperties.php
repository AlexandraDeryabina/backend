<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Criteria;
use App\Entity\User;
use App\Entity\UserSelectedValue;
use App\Repository\UserPropertiesRepository;
use App\Repository\UserSelectedValueRepository;

class UserProperties
{
    /**
     * @var UserSelectedValueRepository
     */
    private $selectedValueRepository;
    /**
     * @var UserPropertiesRepository
     */
    private $propertiesRepository;

    public function __construct(
        UserSelectedValueRepository $selectedValueRepository,
        UserPropertiesRepository $propertiesRepository
    )
    {
        $this->selectedValueRepository = $selectedValueRepository;
        $this->propertiesRepository = $propertiesRepository;
    }

    /**
     * @return UserSelectedValue[]
     */
    public function getProperties(Criteria $criteria, User $user): array
    {
        /** @var \App\Entity\UserProperties $userProperty */
        $userProperty = $this->propertiesRepository->findOneBy(
            [
                'criteria_id' => $criteria->getId(),
                'user'        => $user->getId(),
            ]
        );

        return $this->selectedValueRepository->findBy(['user_property_id' => $userProperty->getId()]);
    }
}
