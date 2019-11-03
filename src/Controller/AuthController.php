<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\AuthRequest;
use App\Dto\AuthResponse;
use App\Service\AuthService;
use App\Service\Exception\InvalidPasswordException;
use App\Service\Exception\UserNotRegisteredException;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends AbstractFOSRestController
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @Rest\Post("/auth")
     */
    public function auth(Request $request): Response
    {
        $authRequest = AuthRequest::fromRequest($request);
        try {
            $user = $this->authService->auth($authRequest);
        } catch (UserNotRegisteredException $e) {
            try {
                $user = $this->authService->register($authRequest);
            } catch (Exception $e) {
                return $this->json(['message' => $e->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
            }
        } catch (InvalidPasswordException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(AuthResponse::fromUser($user)->toArray(), Response::HTTP_OK);
    }
}
