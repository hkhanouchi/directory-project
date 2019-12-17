<?php

namespace AppBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;

class ShowUserListener {

    protected $container ;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Show the user
     * @param ShowUserEvent $event
     */
    public function onShowUser(ShowUserEvent $event)
    {

        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $event->setUser($user);
    }

}