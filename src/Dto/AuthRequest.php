<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

class AuthRequest
{
    /** @var string */
    private $telegram;

    /** @var string */
    private $password;

    public function __construct(string $telegram, string $password)
    {
        $this->telegram = $telegram;
        $this->password = $password;
    }

    public static function fromRequest(Request $request): self
    {
        $data = json_decode($request->getContent(), true);

        return new self($data['telegram'], $data['password']);
    }

    public function getTelegram(): string
    {
        return $this->telegram;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
