<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CriteriaValuesRepository")
 * @ORM\Table(name="criteria_values")
 */
class CriteriaValues
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
     * @ManyToOne(targetEntity="Criteria", inversedBy=null)
     * @JoinColumn(name="criteria_id", referencedColumnName="id")
     * @var ?Criteria
     */
    private $criteria;


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

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setCriteria($criteria): self
    {
        $this->criteria = $criteria;

        return $this;
    }
}