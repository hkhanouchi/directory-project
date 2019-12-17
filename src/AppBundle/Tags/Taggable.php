<?php
namespace AppBundle\Tags;

trait Taggable {

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TypologieTag", cascade={"persist"})
     */
    private $typologie;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TechnologieTag", cascade={"persist"})
     */
    private $technologie;

    /**
     * Add typologie
     *
     * @param \AppBundle\Entity\TypologieTag $typologie
     *
     * @return Project
     */
    public function addTypologie(\AppBundle\Entity\TypologieTag $typologie)
    {
        $this->typologie[] = $typologie;

        return $this;
    }

    /**
     * Remove typologie
     *
     * @param \AppBundle\Entity\TypologieTag $typologie
     */
    public function removeTypologie(\AppBundle\Entity\TypologieTag $typologie)
    {
        $this->typologie->removeElement($typologie);
    }

    /**
     * Get typologie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypologie()
    {
        return $this->typologie;
    }

    /**
     * Add technologie
     *
     * @param \AppBundle\Entity\TechnologieTag $technologie
     *
     * @return Project
     */
    public function addTechnologie(\AppBundle\Entity\TechnologieTag $technologie)
    {
        $this->technologie[] = $technologie;

        return $this;
    }

    /**
     * Remove technologie
     *
     * @param \AppBundle\Entity\TechnologieTag $technologie
     */
    public function removeTechnologie(\AppBundle\Entity\TechnologieTag $technologie)
    {
        $this->technologie->removeElement($technologie);
    }

    /**
     * Get technologie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTechnologie()
    {
        return $this->technologie;
    }


}