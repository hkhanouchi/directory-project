<?php
namespace AppBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Form\DataTransformer\TechnologieTagsTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologieTagsType extends AbstractType {

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TechnologieTagsTransformer($this->manager), true);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr', [
            'class' => 'tag-input'
        ]);
        $resolver->setDefault('required', true);
    }

    public function getParent (): string {
        return TextType::class;
    }

}