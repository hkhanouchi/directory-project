<?php
namespace AppBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\TypologieTag;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TypologieTagsTransformer implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($value): string
    {
        return implode(',', $value);
    }

    public function reverseTransform($string): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $string))));
        $tags = $this->manager->getRepository('AppBundle:TypologieTag')->findBy([
            'name' => $names
        ]);
        $newNames = array_diff($names, $tags);
        foreach ($newNames as $name) {
            $tag = new TypologieTag();
            $tag->setName($name);
            $tags[] = $tag;
        }
        return $tags;
    }
}