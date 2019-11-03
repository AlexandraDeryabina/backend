<?php
declare(strict_types=1);

namespace App\Service;

use App\Dto\AuthRequest;
use App\Entity\User;
use App\Service\Exception\InvalidPasswordException;
use App\Service\Exception\UserNotRegisteredException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthService
{
    const SESSION_KEY = 'user_session';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    /**
     * @throws InvalidPasswordException
     * @throws UserNotRegisteredException
     */
    public function auth(AuthRequest $request): User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['telegram' => $request->getTelegram()]);
        if (!$user) {
            throw new UserNotRegisteredException;
        }
        if ($user->getPassword() !== $request->getPassword()) {
            throw new InvalidPasswordException("Неправильный пароль пользователя");
        }

        return $user;
    }

    /**
     * @throws UserNotRegisteredException
     */
    public function authByToken(string $token): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['token' => $token]);
        if (!$user) {
            throw new UserNotRegisteredException;
        }

        $this->writeToSession($user);
    }

    /**
     * @throws Exception
     */
    public function register(AuthRequest $request): User
    {
        $user = new User();
        $user->setTelegram($request->getTelegram())
             ->setPassword($request->getPassword())
             ->setToken(bin2hex(random_bytes(20)));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @throws Exception
     */
    public function getCurrentUser(): User
    {
        $user = $this->session->get(self::SESSION_KEY, false);

        if ($user instanceof User) {
            return $user;
        }

        throw new Exception("Отсутствует авторизация");
    }

    public function logout(): void
    {
        $this->session->remove(self::SESSION_KEY);
    }

    private function writeToSession(User $user): void
    {
        $this->session->set(self::SESSION_KEY, $user);
    }
}
