<?php

namespace App\EventSubscriber;

use App\Repository\NavigationItemRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class NavigationSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $navRepository;

    public function __construct(Environment $twig, NavigationItemRepository $navRepository)
    {
        $this->twig = $twig;
        $this->navRepository = $navRepository;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        // Tech Lead logic: Retrieve all menu items in order
        $navItems = $this->navRepository->findBy([], ['position' => 'ASC']);

        // Pass it to Twig as a global variable
        // So we can use the 'dynamic_nav' variable anywhere in base.html.twig
        $this->twig->addGlobal('dynamic_nav', $navItems);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}