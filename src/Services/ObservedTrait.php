<?php


namespace App\Services;


trait ObservedTrait
{
    /** @var Observer[] */
    private $observers = [];

    public function addObserver(Observer $observer) : void
    {
        $this->observers[] = $observer;
    }
}