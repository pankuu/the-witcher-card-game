<?php


namespace App\Helper;


interface CardValidateInterface
{
    /**
     * @param string|null $title
     * @param string|null $power
     * @return array
     */
    public function postValidate(?string $title, ?string $power): array;

    /**
     * @param string|null $title
     * @param string|null $power
     * @return array
     */
    public function patchValidate(?string $title, ?string $power): array;

    /**
     * @param array $input
     * @param $constraints
     * @return array
     */
    public function validate(array $input, $constraints): array;
}
