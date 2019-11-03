<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\Group as GroupEntity;

class Group
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

    public static function fromEntity(GroupEntity $group): self
    {
        return new self($group->getId(), $group->getName());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return ['id' => $this->getId(), 'name' => $this->getName()];
    }
}
