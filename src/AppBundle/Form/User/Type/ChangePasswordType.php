<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\User\Type;

use Symfony\Component\Form\AbstractType;

class ChangePasswordType extends AbstractType
{

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ChangePasswordFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_change_password';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
