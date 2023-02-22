<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Profile;
use App\Entity\User;
use EsperoSoft\Faker\Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();
        $user = [];
        for ($i=0; $i < 100; $i++) { 
            $user = (new User())->setFullName($faker->full_name())
                ->setEmail($faker->email())
                ->setPassword(sha1("dfsfsdferfger"))
                ->setcreatedAt($faker->dateTimeImmutable());
                $address = (new Address())->setStreet($faker->streetAddress())
                                          ->setCodePostal($faker->codepostal())
                                          ->setCity($faker->city())
                                          ->setCountry($faker->country())
                                          ->setcreatedAt($faker->dateTimeImmutable());

                $profile = (new Profile())->setPicture($faker->image())
                                          ->setCoverPicture($faker->image())
                                          ->setDescription($faker->description(60))
                                          ->setcreatedAt($faker->dateTimeImmutable());
    
                
                                          
               
                $user->addAddress($address);
                $user->setProfile($profile);
                $users[] = $user;
                $manager->persist($address);
                $manager->persist($profile);
                $manager->persist($user);
                
        }

       // $category = [];
        $names = [
            "Actualités",
            "Economie",
            "Formation Mudey",
            "Sports",
            "Politique",
            "Situation en Ukraine",
            "Divers"
        ];
        for ($i=0; $i < count($names); $i++) { 
            $category = (new Category())->setName($names[$i])
                                        ->setDescription("Description de ; ".$names[$i])
                                        ->setImageUrl($faker->image())
                                        ->setcreatedAt($faker->dateTimeImmutable()); 
           // $categories[] = $category;
            $manager->persist($category);
        }

     //   $article = [];
     //   for ($i=0; $i < 300; $i++) { 
      //      $article = (new Article())->setTitle($faker->description(30))
      //                                  ->setContent($faker->text(60))
      //                                  ->setImageUrl($faker->image())
      //                                  ->setcreatedAt($faker->dateTimeImmutable())
      //                                  ->setAuthor($users[rand(0, count($users) -1)])
      //                                  ->addCategory($categories[rand(0, count($categories) -1)]); 
      //      $articles[] = $article;
      //      $manager->persist($article);
     //   }
                
            $manager->flush();
    }
}
