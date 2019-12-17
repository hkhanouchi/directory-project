<?php

namespace AppBundle\Controller;


use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Controller\SidebarController as MasterSidebarController;

class SidebarController extends MasterSidebarController
{

    /**
     * @return EventDispatcher
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }

    public function searchFormAction()
    {


        return $this->render('AvanzuAdminThemeBundle:Sidebar:search-form.html.twig', array());
    }

    public function menuAction(Request $request)
    {

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_SIDEBAR_SETUP_MENU)) {
            return new Response();
        }

        $event   = $this->getDispatcher()->dispatch(ThemeEvents::THEME_SIDEBAR_SETUP_MENU,new SidebarMenuEvent($request));

        return $this->render(
                    ':Sidebar:menu.html.twig',
                        array(
                            'menu' => $event->getItems()
                        )
        );
    }
}