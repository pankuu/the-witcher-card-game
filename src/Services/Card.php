<?php


namespace App\Services;


interface Card
{
    public function move(): void;

    public function getPowerBonus(): int;

    public function getCard($id): void;

    public function getName(): string;

    public function getType(): string;
}