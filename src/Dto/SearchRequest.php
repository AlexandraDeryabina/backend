<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

class SearchRequest
{
    /** @var int */
    private $groupId;

    /** @var UserCriteria[] */
    private $userCriterias;

    /** @var int */
    private $userId;

    public function __construct(int $groupId, int $userId, array $userCriterias)
    {
        $this->groupId = $groupId;
        $this->userId = $userId;
        $this->userCriterias = array_map(function (array $criteria) {
            return new UserCriteria($criteria['criteriaId'], $criteria['weight'], $criteria['values']);
        }, $userCriterias);
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return UserCriteria[]
     */
    public function getUserCriterias(): array
    {
        return $this->userCriterias;
    }

    public static function fromRequest(Request $request): self
    {
        $content = json_decode($request->getContent(), true);

        return new self((int)$content['groupId'],(int)$content['userId'], $content['userCriterias']);
    }
}
