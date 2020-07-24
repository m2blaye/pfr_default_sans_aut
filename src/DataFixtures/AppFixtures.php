<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     * L'encodeur de mot de pass
    */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
    
        $faker = Factory::create('fr_FR');

        for($i=0;$i<4;$i++) {

            $profil = new Profil();

            $profil->setProfil($faker->unique()->randomElement(['Administrateur', 'CM', 'Formateur','Apprenant']));

            $manager->persist($profil);


                $user = new User();

                $hash = $this->encoder->encodePassword($user,"passer");

                $user->setNom($faker->lastName)
                    ->setPrenom($faker->firstName)
                    ->setGenre($faker->randomElement(['Homme', 'Femmme']))
                    ->setUsername($faker->userName)
                    ->setPassword($hash)
                    ->setMail($faker->email)
                    ->setTel($faker->phoneNumber)
                    ->setPhoto("default.png")
                    ->setStatus(1)
                    ->setProfil($profil);

                $manager->persist($user);

        }

        $manager->flush();
    }
}
