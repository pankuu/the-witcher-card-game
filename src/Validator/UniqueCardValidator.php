<?php

namespace App\Validator;

use App\Repository\CardRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueCardValidator extends ConstraintValidator
{
    /**
     * @var CardRepository
     */
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Assert\Callback()
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint UniqueCard */

        $existingCard = $this->cardRepository->findOneBy([
            'title' => $value
        ]);

        if (!$existingCard) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
