<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Request\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class CreateTicketValidator extends Validator
{
    protected function validate(array $data): void
    {
        $constraints = new Assert\Collection([
            'title' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 1, 'max' => 255])
            ],
            'description' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 1, 'max' => 10_000])
            ],
            'categoryId' => [
                new Assert\NotBlank(),
                new Assert\Uuid()
            ],
            'authorId' => [
                new Assert\NotBlank(),
                new Assert\Uuid()
            ]
        ]);

        $listOfErrors = Validation::createValidator()->validate($data, $constraints);
        $this->mapErrors($listOfErrors);
    }
}