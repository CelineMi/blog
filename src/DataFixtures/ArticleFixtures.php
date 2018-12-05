<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 50; $i++)
        {
            $article = new Article();
            $slugify = new Slugify();
            $article->setTitle(mb_strtolower($faker->sentence()));
            //generer le slug du titre
            $slug = $slugify->generate($article->getTitle());
            $article->setSlug($slug);
            $article->setContent(mb_strtolower($faker->text(200)));
            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_' . rand(0,4)));
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}