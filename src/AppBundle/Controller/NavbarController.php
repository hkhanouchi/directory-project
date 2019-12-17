<?php

namespace AppBundle\Controller;


use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Controller\NavbarController as MasterNavBarController;

class NavbarController extends MasterNavBarController
{

    public function projectsAction($max = 5)
    {

        return $this->render(
                    ':Navbar:projects.html.twig',
                        array(
                            'messages' => 'rien',
                            'total'    => '10'
                        )
        );
    }
}