<?php

namespace AppBundle\Controller\User;


use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Controller\SidebarController as MasterSidebarController;

class SidebarController extends MasterSidebarController
{

    public function userPanelAction()
    {

        $userEvent = new ShowUserEvent();

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_SIDEBAR_USER)) {
            return new Response();
        }
        $this->getDispatcher()->dispatch(ThemeEvents::THEME_SIDEBAR_USER, $userEvent);

        return $this->render(
                    ':Sidebar:user-panel.html.twig',
                        array(
                            'user' => $userEvent->getUser()
                        )
        );
    }

    /**
     * @return EventDispatcher
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }
}