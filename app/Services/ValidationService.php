<?php

namespace App\Services;

use App\Interfaces\ValidationInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ValidationService implements ValidationInterface
{
    protected int $statusCode = 422;
    protected bool $withErrors = true;
    protected array $errors = [];
    protected array $data = [];
    protected array $rules = [];
    protected string $message = 'Validation error';
    protected array $request = [];

    /**
     * @return $this
     */
    public function withoutErrors(): ValidationService
    {
        $this->withErrors = false;
        return $this;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function statusCode(int $code): ValidationService
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function errors(array $errors): ValidationService
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function data(array $data): ValidationService
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message): ValidationService
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $request
     * @return $this
     */
    public function request(array $request): ValidationService
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     * @throws ValidationException
     */
    public function make(array $rules, array $messages = [], array $customAttributes = []): \Illuminate\Contracts\Validation\Validator
    {
        $request = !empty($this->request) ? $this->request : request()->all();

        $validator = Validator::make($request, $rules, $messages, $customAttributes);

        if ($validator->stopOnFirstFailure()->fails()) throw new ValidationException($validator, response()->json([
            'status' => false,
            'message' => $this->message,
            'error' => ($this->withErrors ? (empty($this->errors) ? $validator->errors() : $this->errors) : []),
            'data' => []
        ], $this->statusCode));

        return $validator;
    }
}
