<?php
namespace AppBundle\Model;

use Avanzu\AdminThemeBundle\Model\UserInterface as ThemeUser;
use AppBundle\Entity\User\User;

class UserModel implements ThemeUser {

    /**
     * @var User
     */
    var $user;

    private function getUser() {
        if (is_null($this->user)){
            //getuser
            
        }
        return $this->user;
     }

	public function getAvatar() {
        return $this->getUser()->getAvatar();
    }

    public function getUsername() {
        return $this->getUser()->getUsername();
    }

    public function getName() {
        return $this->getUser()->getName();
    }
    public function getMemberSince() {
        return $this->getUser()->getMemberSince();
    }

    public function isOnline() {
        return $this->getUser()->isOnline();
    }

    public function getIdentifier() {
        return $this->getUser()->getIdentifier();
    }

    public function getTitle() {
        return $this->getUser()->getTitle();
    }
}