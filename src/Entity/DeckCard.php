<?php

namespace App\Entity;

use App\Repository\DeckCardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeckCardRepository::class)
 */
class DeckCard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $deck_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $card_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeckId(): ?int
    {
        return $this->deck_id;
    }

    public function setDeckId(int $deck_id): self
    {
        $this->deck_id = $deck_id;

        return $this;
    }

    public function getCardId(): ?int
    {
        return $this->card_id;
    }

    public function setCardId(int $card_id): self
    {
        $this->card_id = $card_id;

        return $this;
    }
}
