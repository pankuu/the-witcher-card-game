<?php

namespace App\Validator;

use App\Repository\CardRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BlockedCardValidator extends ConstraintValidator
{
    /**
     * @var CardRepository
     */
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\BlockedCard */

        $blockedCard = $this->cardRepository->findOneBy([
            'title' => $value,
            'isBlocked' => true
        ]);

        if ($blockedCard) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
