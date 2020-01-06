<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Request\Validator;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class EditCategoryValidator extends Validator
{
    protected function validate(array $data): void
    {
        $constraints = new Assert\Collection([
            'id' => [
                new Assert\NotBlank(),
                new Assert\Uuid()
            ],
            'name' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 1, 'max' => 100])
            ]
        ]);

        $listOfErrors = Validation::createValidator()->validate($data, $constraints);
        $this->mapErrors($listOfErrors);
    }
}