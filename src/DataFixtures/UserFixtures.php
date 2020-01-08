<?php

namespace App\DataFixtures;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Continent;
use App\Entity\Comment;
use App\Entity\Country;
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


        $continent = new Continent();
        $continent->setName("Europe");
        $manager->persist($continent);
        $manager->flush();

        $continent2 = new Continent();
        $continent2->setName("Amérique");
        $manager->persist($continent2);
        $manager->flush();

        $country = new Country();
        $country->setName("France")
            ->setContinent($continent)
            ->setSlug(strtolower($slugger->slug($country->getName())));
        $manager->persist($country);
        $manager->flush();

        $country2 = new Country();
        $country2->setName("Greece")
            ->setContinent($continent)
            ->setSlug(strtolower($slugger->slug($country2->getName())));
        $manager->persist($country2);
        $manager->flush();

        $country3 = new Country();
        $country3->setName("Canada")
            ->setContinent($continent2)
            ->setSlug(strtolower($slugger->slug($country3->getName())));
        $manager->persist($country3);
        $manager->flush();

        $country4 = new Country();
        $country4->setName("États-Unis")
            ->setContinent($continent2)
            ->setSlug(strtolower($slugger->slug($country4->getName())));
        $manager->persist($country4);
        $manager->flush();

        $category = new Category();
        $category->setName("lieux touristiques");
        $manager->persist($category);
        $manager->flush();


        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($this->faker->title)
                ->setImage($this->faker->imageUrl($width = 640, $height = 480, 'cats', true, 'faker'))
                ->setContent($this->faker->realText(200, 2))
                ->setTags($this->faker->realText("20"))
                ->setUser($userValerie)
                ->setCreatedAt($this->faker->dateTimeThisDecade)
                ->setIsSignaled(true)
                ->setCountry($country)
                ->setSlug(strtolower($slugger->slug($article->getTitle())))
                ->setCategory($category);
            $manager->persist($article);
            $manager->flush();
        }

//generer des commentaires à l'article aléatoirement entre 1 et 10 avec 2 paragraphe//

        for ($k = 1; $k <= mt_rand(3, 15); $k++) {

            $comment = new Comment();

            //permet de creer des paragraphes
            $content = '<p>' . join($faker->paragraphs(5),
                    '</p><p>') . '</p>';

            //prend la date d'aujourd'hui et gere la difference avec le dateTimeBetween pour avoir des dates cohérentes//
            $days = (new \DateTime())->diff($article->getCreatedAt())->days;

            $comment->setUser($userValerie)
                ->setContent($content)
                ->setCreatedAt($faker->dateTimeBetween('-' . $days . 'days'))
                ->setArticle($article);
        }
        $manager->flush();





    }
}
