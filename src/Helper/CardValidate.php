<?php


namespace App\Helper;


use App\Validator\BlockedCard;
use App\Validator\UniqueCard;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CardValidate implements CardValidateInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string|null $title
     * @param string|null $power
     * @return array
     */
    public function postValidate(?string $title, ?string $power): array
    {
        $input = ['title' => $title, 'power' => $power];

        $constraints = new Assert\Collection([
            'fields' => [
                'title' => new Assert\Required([
                    new BlockedCard(),
                    new UniqueCard(),
                    new Assert\Length(['min' => 1]),
                    new Assert\NotBlank()
                ]),
                'power' => new Assert\Required([
                    new Assert\PositiveOrZero(),
                    new Assert\NotBlank()
                ])
            ],
        ]);

        return $this->validate($input, $constraints);
    }

    /**
     * @param string|null $title
     * @param string|null $power
     * @return array
     */
    public function patchValidate(?string $title, ?string $power): array
    {
        $input = ['title' => $title, 'power' => $power];

        $constraints = new Assert\Collection([
            'fields' => [
                'title' => new Assert\Optional([
                    new BlockedCard(),
                    new UniqueCard(),
                    new Assert\Length(['min' => 1]),
                ]),
                'power' => new Assert\Optional([
                    new Assert\PositiveOrZero(),
                ])
            ],
        ]);

        return $this->validate($input, $constraints);
    }

    /**
     * @param array $input
     * @param $constraints
     * @return array
     */
    public function validate(array $input, $constraints): array
    {
        $violations = $this->validator->validate($input, $constraints);

        $errorMessages = [];

        if (count($violations) > 0) {
            $accessor = PropertyAccess::createPropertyAccessor();
            foreach ($violations as $violation) {
                $accessor->setValue($errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage());
            }
        }

        return $errorMessages;
    }
}
