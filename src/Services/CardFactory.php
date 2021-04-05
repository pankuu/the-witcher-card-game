<?php


namespace App\Services;


class CardFactory
{
    const HOST = 'Host';
    const GUEST = 'Guest';

    private static $entityManager;

    public static function setEntityManager($entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function factory(string $type, string $name, int $numberOfCards): Card
    {
        $card = null;

        switch ($type) {
            case self::HOST:
                $card = new Host($name, $numberOfCards, self::$entityManager);
                break;
            case self::GUEST;
                $card = new Guest($name, $numberOfCards, self::$entityManager);
                break;

            default:
                throw new \Exception('Could not recognize type');
        }

        return $card;
    }
}
