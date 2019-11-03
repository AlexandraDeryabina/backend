<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CriteriaRepository")
 * @ORM\Table(name="criteria")
 */
class Criteria
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ManyToOne(targetEntity="Group", inversedBy=null)
     * @JoinColumn(name="group_id", referencedColumnName="id")
     * @var ?Group
     */
    private $group;

    /**
     * @ManyToOne(targetEntity="CriteriaType", inversedBy=null)
     * @JoinColumn(name="criteria_type_id", referencedColumnName="id")
     * @var ?Group
     */
    private $criteriaType;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $multiple = false;

    /**
     * @ORM\OneToMany(targetEntity="CriteriaValues", mappedBy="criteria", fetch="LAZY")
     * @JoinColumn(name="id", referencedColumnName="criteria_id")
     * @var CriteriaValues[]|\Doctrine\ORM\PersistentCollection
     */
    private $values;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup($group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getCriteriaType(): ?CriteriaType
    {
        return $this->criteriaType;
    }

    public function setCriteriaType($criteriaType): self
    {
        $this->criteriaType = $criteriaType;

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function setMultiple(bool $multiple): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }
}
