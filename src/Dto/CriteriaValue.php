<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\CriteriaValues;

class CriteriaValue
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

    public static function fromEntity(CriteriaValues $entity): self
    {
        return new self($entity->getId(), $entity->getName());
    }

    public function toArray(): array
    {
        return ['id' => $this->getId(), 'name' => $this->getName()];
    }
}
