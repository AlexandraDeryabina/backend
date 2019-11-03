<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultUserRepository")
 * @ORM\Table(name="result_user")
 */
class ResultUser
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
     * @ManyToOne(targetEntity="Result", inversedBy=null)
     * @JoinColumn(name="result_id", referencedColumnName="id")
     * @var ?Result
     */
    private $result;

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

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result): self
    {
        $this->result = $result;

        return $this;
    }
}