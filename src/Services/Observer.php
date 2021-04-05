<?php


namespace App\Services;


interface Observer
{
    public function notify(string $event): array;
}