<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\Criteria as CriteriaEntity;
use App\Entity\CriteriaValues;

class Criteria
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Group */
    private $group;

    /** @var CriteriaType */
    private $criteriaType;

    /** @var bool */
    private $multiple;

    /** @var CriteriaValue[] */
    private $values;

    public function __construct(int $id, string $name, Group $group, CriteriaType $criteriaType, bool $multiple,
                                array $values)
    {
        $this->id = $id;
        $this->name = $name;
        $this->group = $group;
        $this->criteriaType = $criteriaType;
        $this->multiple = $multiple;
        $this->values = array_map(
            function (CriteriaValues $criteriaValues) {
                return CriteriaValue::fromEntity($criteriaValues);
            }, $values);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getCriteriaType(): CriteriaType
    {
        return $this->criteriaType;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public static function fromEntity(CriteriaEntity $criteria): self
    {
        return new self(
            $criteria->getId(),
            $criteria->getName(),
            Group::fromEntity($criteria->getGroup()),
            CriteriaType::fromEntity($criteria->getCriteriaType()),
            $criteria->isMultiple(),
            $criteria->getValues()->toArray()
        );
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->getId(),
            'name'         => $this->getName(),
            'group'        => $this->getGroup()->toArray(),
            'criteriaType' => $this->getCriteriaType()->toArray(),
            'multiple'     => $this->isMultiple(),
            'values'       => array_map(function (CriteriaValue $criteriaValue) {
                return $criteriaValue->toArray();
                }, $this->getValues())
        ];
    }
}
