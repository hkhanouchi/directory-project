<?php

namespace AppBundle\Form;

use AppBundle\Form\TypologieTagsType;
use AppBundle\Form\TechnologieTagsType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'form.label.name'])
            ->add('longname', null, ['label' => 'form.label.description'])
            ->add('url_jira', null, ['label' => 'form.label.url_jira'])
            ->add('url_git', null, ['label' => 'form.label.url_git'])
            ->add('commercial_fullname', null, ['label' => 'form.label.commercial_fullname'])
            ->add('commercial_email', null, ['label' => 'form.label.commercial_email'])
            ->add(
                'client',
                null,
                [
                    'label' => 'form.label.customer',
                    'placeholder' => 'form.select.placeholder',
                ]
            )
            ->add('technologie', TechnologieTagsType::class, ['label' => 'form.label.technologie', 'attr' => ['data-help' => 'Ex: Tag1,Tag2,..']])
            ->add('typologie', TypologieTagsType::class, ['label' => 'form.label.typologie', 'attr' => ['data-help' => 'Ex: Tag1,Tag2,..']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_project';
    }


}
