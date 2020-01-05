<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Request\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class CreateCategoryValidator extends Validator
{
    protected function validate(array $data): void
    {
        $constraints = new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 1, 'max' => 255])
            ]
        ]);

        $listOfErrors = Validation::createValidator()->validate($data, $constraints);
        $this->mapErrors($listOfErrors);
    }
}