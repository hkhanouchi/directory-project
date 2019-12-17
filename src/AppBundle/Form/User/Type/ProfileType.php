<?php

namespace AppBundle\Form\User\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('current_password')
            ->add('first_name', null, array('label' => 'profile.edit.firstname', 'translation_domain' => 'messages'))
            ->add('last_name', null, array('label' => 'profile.edit.lastname', 'translation_domain' => 'messages'));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
