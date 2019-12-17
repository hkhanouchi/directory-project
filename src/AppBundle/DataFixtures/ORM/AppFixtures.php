<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use AppBundle\Entity\User\Client;
use AppBundle\Entity\Project;
use AppBundle\Entity\User\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AppFixtures
 * @package CoreBundle\DataFixtures\ORM
 */
class AppFixtures extends AbstractFixture implements ContainerAwareInterface, FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        // initialisation de l'objet Faker
        $faker = Faker\Factory::create('fr_FR');

        // Users
        $users = [];
        for ($i = 0; $i < 15; $i++) {
            $users[$i] = new User();
            $users[$i]->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setUserName($faker->userName)
                ->setEmail($faker->email)
                ->setPassword($faker->password(8))
                ->setCreatedAt($faker->dateTime())
                ->setEnabled(true);
            $em->persist($users[$i]);
        }

        // Clients
        $customers = [];
        for ($i = 0; $i < 15; $i++) {
            $customers[$i] = new Client();
            $customers[$i]->setName($faker->company)
                ->setEmail($faker->companyEmail)
                ->setContact($faker->email);

            $random_users = array_rand($users, 2);
            foreach ($random_users as $key => $val) {
                $customers[$i]->addUser($users[$val]);
            }
            $em->persist($customers[$i]);
        }

        // Projects
        $projects= [];
        for ($i = 0; $i < 20; $i++) {
            $projects[$i] = new Project();
            $projects[$i]->setName($faker->name)
                ->setLongname($faker->text())
                ->setUrlJira($faker->url)
                ->setUrlGit($faker->url)
                ->setClient($customers[count(array_rand($customers))])
                ->setManager($users[count(array_rand($users))])
                ->setCommercialFullname(sprintf('%s %s', $faker->firstName(), $faker->lastName))
                ->setCommercialEmail($faker->email)
                ->setTechnologie($faker->text(20))
                ->setTypologie($faker->text(20))
                ->setCreatedAt($faker->dateTime());

            $em->persist($projects[$i]);
        }

        $em->flush();

    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}