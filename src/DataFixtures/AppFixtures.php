<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Là, on a instancié faker
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();
            $title = $faker->sentence();
            // Donc "slug" est là pour faire en sorte de créer une "url" plus propre...
            $slug = $slugify->slugify($title);
            // $cover image, c'est un lorem ipsum d'image...http//picsum.photos...(plusieurs catégories)
            $coverImage = 'https://picsum.photos/seed/picsum/1000/350';
            // c'est pour avoir un paragraph, avec 2 phrases dedans, car par défault, c'est 3.
            $introduction = $faker->paragraph(2);
            // le join fait une boucle de caractère mais sous forme tableau mais nous, on veut une string( chaîne de caractère), donc dans la parenthèse, on met <p></p>, ça équivaut à un <br>.
            $content = '<p>' . join('<p></p>', $faker->paragraphs(5)) . '</p>';
            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(rand(40, 200))
                ->setRooms(rand(1, 5));

            $manager->persist($ad);

            // Gestion de la galerie image de l'annonce
            for ($g = 1; $g <= rand(2, 5); $g++) {
                $image = new Image();
                $image->setUrl('https://picsum.photos.id/' . $g . '/900')
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
