<?php
declare(strict_types=1);

namespace App\Listener;

use App\Controller\TokenAuthenticatedControllerInterface;
use App\Service\AuthService;
use App\Service\Exception\UserNotRegisteredException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RequestListener implements EventSubscriberInterface
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedControllerInterface) {
            $content = json_decode($event->getRequest()->getContent(), true);
            if (!isset($content['token'])) {
                throw new AccessDeniedException('Token not found');
            }
            try {
                $this->authService->authByToken($content['token']);
            } catch (UserNotRegisteredException $e) {}
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
