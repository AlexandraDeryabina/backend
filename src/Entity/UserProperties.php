<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserPropertiesRepository")
 * @ORM\Table(name="user_properties")
 */
class UserProperties
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy=null)
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * @var ?User
     */
    private $user;


    /**
     * @ManyToOne(targetEntity="Criteria", inversedBy=null)
     * @JoinColumn(name="criteria_id", referencedColumnName="id")
     * @var ?Criteria
     */
    private $criteria;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $weight;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

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