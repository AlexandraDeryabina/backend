<?php
declare(strict_types=1);

namespace App\Dto;

class UserCriteria
{
    /** @var int */
    private $criteriaId;
    /** @var int */
    private $weight;
    /** @var int[]|string[] */
    private $values;

    public function __construct(int $criteriaId, int $weight, array $values)
    {
        $this->criteriaId = $criteriaId;
        $this->weight = $weight;
        $this->values = $values;
    }

    /**
     * @return int
     */
    public function getCriteriaId(): int
    {
        return $this->criteriaId;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return int[]|string[]
     */
    public function getValues()
    {
        return $this->values;
    }
}
