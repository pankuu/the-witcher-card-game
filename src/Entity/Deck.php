<?php

namespace App\Entity;

use App\Repository\DeckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeckRepository::class)
 */
class Deck
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

//    /**
//     * @return Collection|Card[]
//     */
//    public function getCards(): Collection
//    {
//        return $this->cards;
//    }
//
//    public function addCard(Card $card): self
//    {
//        if (!$this->cards->contains($card)) {
//            $this->cards[] = $card;
//        }
//
//        return $this;
//    }
//
//    public function removeCard(Card $card): self
//    {
//        $this->cards->removeElement($card);
//
//        return $this;
//    }
}
