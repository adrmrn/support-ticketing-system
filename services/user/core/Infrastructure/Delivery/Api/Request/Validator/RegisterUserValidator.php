<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Api\Request\Validator;

use Illuminate\Http\Request;

class RegisterUserValidator extends Validator
{
    public function isValid(Request $request): bool
    {
        $data = $request->only(['firstName', 'lastName', 'email', 'password']);
        $rules = [
            'firstName' => ['required', 'string', 'min:1', 'max:255'],
            'lastName' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ];
        $validator = $this->validatorFactory()->make($data, $rules);
        $this->setErrors($validator->errors());
        return !$validator->fails();
    }
}
