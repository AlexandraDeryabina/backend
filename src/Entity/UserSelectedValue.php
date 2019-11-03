<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSelectedValueRepository")
 * @ORM\Table(name="user_selected_value")
 */
class UserSelectedValue
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
    private $value;

    /**
     * @ManyToOne(targetEntity="UserProperties", inversedBy=null)
     * @JoinColumn(name="user_property_id", referencedColumnName="id")
     * @var UserProperties
     */
    private $userProperty;

    /**
     * @ManyToOne(targetEntity="CriteriaValues", inversedBy=null)
     * @JoinColumn(name="criteria_value_id", referencedColumnName="id")
     * @var CriteriaValues
     */
    private $criteriaValues;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUserProperty()
    {
        return $this->userProperty;
    }

    public function setUserProperty($userProperty): self
    {
        $this->userProperty = $userProperty;

        return $this;
    }

    public function getCriteriaValues()
    {
        return $this->criteriaValues;
    }

    public function setCriteriaValues($criteriaValues): self
    {
        $this->criteriaValues = $criteriaValues;

        return $this;
    }
}
