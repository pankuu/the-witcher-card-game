<?php


namespace App\Services;


class GameBuilder
{
    private $name = '';
    private $numberOfCards = '';
    private $type = '';

    const HOST = 'Host';
    const GUEST = 'Guest';

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $numberOfCards
     */
    public function setNumberOfCards(string $numberOfCards): void
    {
        $this->numberOfCards = $numberOfCards;
    }

    public function build(): Card
    {
        $card = null;
        switch ($this->type) {
            case self::HOST:
            case self::GUEST:
                $card = CardFactory::factory($this->type, $this->name, $this->numberOfCards);
                break;
            default:
                throw new \Exception('Could not recognize type');
        }

        return $card;
    }
}