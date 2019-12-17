<?php

namespace AppBundle\Controller;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Avanzu\AdminThemeBundle\Model\MenuItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Avanzu\AdminThemeBundle\Controller\BreadcrumbController as MasterBreadcrumbController;

/**
 * Controller to handle breadcrumb display inside the layout
 *
 */
class BreadcrumbController extends MasterBreadcrumbController
{


    /**
     * Controller Reference action to be called inside the layout.
     *
     * Triggers the {@link ThemeEvents::THEME_BREADCRUMB} to receive the currently active menu chain.
     *
     * If there are no listeners attached for this event, the return value is an empty response.
     *
     * @param Request $request
     * @param string  $title
     *
     * @return Response
     *
     */
    public function breadcrumbAction(Request $request, $title = '')
    {

        if (!$this->getDispatcher()->hasListeners(ThemeEvents::THEME_BREADCRUMB)) {
            return new Response();
        }

        $active = $this->getDispatcher()->dispatch(ThemeEvents::THEME_BREADCRUMB,new SidebarMenuEvent($request))->getActive();
        /** @var $active MenuItemInterface */
        $list = array();
        if($active) {

            $list[] = $active;
            while(null !== ($item = $active->getActiveChild())) {
                $list[] = $item;
                $active = $item;
            }
        }


        return $this->render(':Breadcrumb:breadcrumb.html.twig', array(
                'active' => $list,
                'title'  => $title
            ));
    }


    /**
     * @return EventDispatcher
     */
    protected function getDispatcher()
    {
        return $this->get('event_dispatcher');
    }

}