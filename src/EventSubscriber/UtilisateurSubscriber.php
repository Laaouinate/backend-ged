<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Document;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UtilisateurSubscriber implements EventSubscriberInterface
{
    public $myToken;

    public function __construct(TokenStorageInterface $myToken)
    {
        $this->myToken = $myToken;
    }

    public function getUserFromToken(GetResponseForControllerResultEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($entity instanceof Document && $method ==  Request::METHOD_POST)
        {
            $agent = $this->myToken->getToken()->getUser();
            $entity->setUser($agent);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.view' => ['getUserFromToken' , EventPriorities::PRE_WRITE],
        ];
    }
}
