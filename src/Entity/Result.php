<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultRepository")
 * @ORM\Table(name="result")
 */
class Result
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
     * @ManyToOne(targetEntity="User", inversedBy=null)
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * @var ?User
     */
    private $initiator;

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

    public function getInitiator()
    {
        return $this->initiator;
    }

    public function setInitiator($initiator): self
    {
        $this->initiator = $initiator;

        return $this;
    }
}
