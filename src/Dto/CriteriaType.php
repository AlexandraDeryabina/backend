<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\CriteriaType as CriteriaTypeEntity;

class CriteriaType
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromEntity(CriteriaTypeEntity $criteriaType): self
    {
        return new self($criteriaType->getId(), $criteriaType->getName());
    }

    public function toArray(): array
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
