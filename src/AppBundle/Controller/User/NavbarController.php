<?php

namespace AppBundle\Controller\User;


use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Controller\NavbarController as MasterNavBarController;

class NavbarController extends MasterNavBarController
{

    public function userAction()
    {

        $userEvent = new ShowUserEvent();

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_NAVBAR_USER)) {
            return new Response();
        }
        $this->getDispatcher()->dispatch(ThemeEvents::THEME_NAVBAR_USER, $userEvent);

        return $this->render(
                  ':Navbar:user.html.twig',
                        array(
                            'user' => $userEvent->getUser()
                        )
        );
    }

}