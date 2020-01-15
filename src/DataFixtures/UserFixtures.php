<?php

namespace App\DataFixtures;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $faker;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = new Factory();
        $this->faker = $this->faker->create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $slugger = new AsciiSlugger();
        $userValerie = new User();
        $userValerie->setEmail("geistval@gmail.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername("valerie-geist")
            ->setPassword($this->passwordEncoder->encodePassword($userValerie, 'Webforce3!'))
            ->setImage(null)
            ->setIsAllowedToPost(true);
        $manager->persist($userValerie);
        $manager->flush();

        $userDylan = new User();
        $userDylan->setEmail("dilan_2006@hotmail.fr")
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername("DylanMasson")
            ->setPassword($this->passwordEncoder->encodePassword($userDylan, 'Webforce3!'))
            ->setImage(null)
            ->setIsAllowedToPost(true);
        $manager->persist($userDylan);
        $manager->flush();

        $userVenelina = new User();
        $userVenelina->setEmail("venita@abv.bg")
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername("venita")
            ->setPassword($this->passwordEncoder->encodePassword($userVenelina, 'Webforce3!'))
            ->setImage(null)
            ->setIsAllowedToPost(true);
        $manager->persist($userVenelina);
        $manager->flush();

        $userJeff = new User();
        $userJeff->setEmail("jeanfaerts@gmail.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setUsername("Jeff")
            ->setPassword($this->passwordEncoder->encodePassword($userJeff, 'Webforce3!'))
            ->setImage(null)
            ->setIsAllowedToPost(true);
        $manager->persist($userJeff);
        $manager->flush();

    }
}
