<?php


namespace App\Services;


class Game implements Observable
{
    use ObservedTrait;

    /** @var Card[] */
    private $cards = [];
    private $result = [];
    private $winner = [];

    public function addCard(Card $card): void
    {
        $this->addObserver($card);
        $this->cards[] = $card;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function run(): array
    {
        foreach ($this->observers as $observer) {
            $this->result[] = $observer->notify('nextTurn');
        }

        $this->getWinnerInfo();
        $this->getWinner();

        return $this->result;
    }

    public function getWinnerInfo(): void
    {
        foreach ($this->result as $key => $value) {
            foreach ($value as $item) {
                $name = array_key_first($value);
                $overall = $item['powerSum'];

                $this->winner[] = [
                    'name' => $name,
                    'overall' => $overall
                ];
            }
        }

        $this->getWinner();
    }

    public function getWinner(): void
    {
        $win = [];

        foreach ($this->winner as $key => $item) {
            if (empty($win)) {
                $win = $item;
            }

            if ($win['overall'] < $item['overall']) {
                $win = "The winner is: {$item['name']}";
            }
        }

        $this->result['message'] = $win;
    }
}
