<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use App\Entity\Departement;
use App\Entity\Document;
use App\Entity\Typedocument;
use App\Entity\User;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder=$passwordEncoder;
        $this->faker=Factory::create();
    } 

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // $manager->flush();
        $this->serviceload($manager);
        $this->userload($manager);
        $this->typeload($manager);
        $this->docload($manager);
        
    }

    public function userload(ObjectManager $manager)
    {
        for($i = 0;$i < 10;$i++)
        {
            $user = new User;
            $user->setNom($this->faker->name);
            $user->setPrenom($this->faker->lastName);
            $user->setEmail($this->faker->email);
            $user->setFonction($this->faker->jobTitle);
            $user->setCreatedAt(new \DateTime());

            $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));

            $deprt = $this->getReference("service_" . rand(0, 3));
            $user->setServ($deprt);

            $this->addReference("utilisateur_$i",$user);

            $manager->persist($user);
        }
            $manager->flush();
    }

    public function serviceload(ObjectManager $manager)
    {
        for($i = 0;$i < 4;$i++)
        {
            $deprt = new Departement;
            $deprt->setDescription('service_$i');
            $deprt->setCreatedAt(new \DateTime());

            $this->addReference("service_$i",$deprt);

            $manager->persist($deprt);
        }
            $manager->flush();
    }


    public function typeload(ObjectManager $manager)
    {
        for($i = 0;$i < 3;$i++)
        {
            $typedocument = new Typedocument;
            $typedocument->setDescriptiontype($this->faker->sentence());
            $typedocument->setCreatedAt(new \DateTime());

            // $document = $this->getReference("doc_" . rand(0, 7));
            // $typedocument->setArchive($document);

            $this->addReference("doc_$i",$typedocument);

            $deprt = $this->getReference("service_" . rand(0, 3));
            $typedocument->setService($deprt);

            $manager->persist($typedocument);
        }
            $manager->flush();
    }

    public function docload(ObjectManager $manager)
    {
        for($i = 0;$i < 8;$i++)
        {
            $document = new Document;

            $document->setNumdecument($this->faker->ean13);
            $document->setInformation($this->faker->sentence());
            $document->setCommentaire($this->faker->realText());
            $document->setCreatedAt(new \DateTime());

            $user = $this->getReference("utilisateur_" . rand(0, 9));
            $document->setUser($user);

            // $this->addReference("doc_$i",$document);

            $typedocument = $this->getReference("doc_" . rand(0,3));
            $document->setArchive($typedocument);

            $manager->persist($document);
        }
            $manager->flush();
    }


}
