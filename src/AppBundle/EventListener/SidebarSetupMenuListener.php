<?php

namespace AppBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;

class SidebarSetupMenuListener
{

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }

    }


    protected function getMenu(Request $request)
    {
        $earg      = array();
        $rootItems = array(
            $dash = new MenuItemModel('dashboard', 'Dashboard', 'app_home', $earg, 'fa fa-dashboard'),
            $profil = new MenuItemModel('profil', 'Profile', 'fos_user_profile_show', $earg, 'fa fa-user'),
            $customer = new MenuItemModel('customer', 'Clients', 'client_index', $earg, 'fa fa-users'),
            $projects = new MenuItemModel('project', 'Projets', '', $earg, 'fa fa-cubes')
        );

        $customer->addChild(new MenuItemModel('list_customer', 'Liste clients', 'client_index', $earg, 'fa fa-list'))
            ->addChild(new MenuItemModel('create_customer', 'Nouveau client', 'client_new', $earg, 'fa fa-user-plus'));

        $projects->addChild(new MenuItemModel('list_project', 'Liste projets', 'project_index', $earg, 'fa fa-list'))
                 ->addChild(new MenuItemModel('create_project', 'Nouveau projet', 'project_new', $earg, 'fa fa-plus-square'));

        return $this->activateByRoute($request->get('_route'), $rootItems);

    }

    protected function activateByRoute($route, $items) {

        foreach($items as $item) { /** @var $item MenuItemModel */
            if($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            }
            else {
                if($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }


}