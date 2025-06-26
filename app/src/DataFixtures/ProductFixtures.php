<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

class ProductFixtures extends Fixture
{
    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $product = new Product();
            $product
                ->setIsActive(true)
                ->setName('Product '.bin2hex(random_bytes(8)))
                ->setPrice((float) mt_rand(10, 1000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
