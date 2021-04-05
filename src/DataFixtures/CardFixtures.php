<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CardFixtures extends Fixture
{
    const CARDS =  [
        'Geralt' => 10,
        'Ciri' => 9,
        'Vesemir' => 5,
        'Triss' => 3,
        'Aard sign' => 0
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CARDS as $title => $power) {
            $card = new Card();
            $card->setTitle($title);
            $card->setPower($power);
            $card->setIsBlocked(true);
            $manager->persist($card);
        }
        $manager->flush();
    }
}
