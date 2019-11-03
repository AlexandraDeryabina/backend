<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;

class AuthResponse
{
    /** @var int */
    private $userId;

    /** @var string */
    private $telegram;

    /** @var string */
    private $token;

    public function __construct(int $userId, string $telegram, string $token)
    {
        $this->userId = $userId;
        $this->telegram = $telegram;
        $this->token = $token;
    }

    public static function fromUser(User $user): self
    {
        return new self($user->getId(), $user->getTelegram(), $user->getToken());
    }

    public function toArray(): array
    {
        return ['user_id' => $this->getUserId(), 'telegram' => $this->getTelegram(), 'token' => $this->getToken()];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTelegram(): string
    {
        return $this->telegram;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
