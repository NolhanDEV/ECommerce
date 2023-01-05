<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
   
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');
        $product = new Products();
        $product->setName('MSI Optix MAG301CR2');
        $product->setDescription('Ecran 29.5 pouces Dalle VA 1ms 200hz');
        $product->setSlug($this->slugger->slug($product->getName())->lower());
        $product->setPrice(38000);
        $product->setStock($faker->numberBetween(0, 10));
        $product->setWeight(7);


        //On va chercher une référence de catégorie
        $category = $this->getReference('cat-3');
        $product->setCategories($category);

        $this->setReference('prod-69', $product);
        $manager->persist($product);

        for($prod = 1; $prod <= 10; $prod++){
            $product = new Products();
            $product->setName($faker->text(15));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000));
            $product->setStock($faker->numberBetween(0, 10));
            $product->setWeight($faker->numberBetween(2, 10));


            //On va chercher une référence de catégorie
            $category = $this->getReference('cat-'. rand(1, 8));
            $product->setCategories($category);

            $this->setReference('prod-'.$prod, $product);
            $manager->persist($product);

          
        }

        $manager->flush();
    }
}
