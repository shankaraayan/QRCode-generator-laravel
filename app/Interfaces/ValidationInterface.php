<?php

namespace App\Interfaces;

use App\Services\ValidationService;

interface ValidationInterface
{
    /**
     * Set custom status code for reponse.
     * @return ValidationService
     */
    public function statusCode(int $code): ValidationService;

    /**
     * Set custom message to the response.
     * @param array $message
     * @return ValidationService
     */
    public function message(string $message): ValidationService;

    /**
     * Set custom data to the response.
     * @param array $data
     * @return ValidationService
     */
    public function data(array $data): ValidationService;

    /**
     * Set custom error to the response.
     * @param array $errors
     * @return ValidationService
     */
    public function errors(array $error): ValidationService;

    /**
     * Set repsonse to be sent without errors
     * @return ValidationService
     */
    public function withoutErrors(): ValidationService;

    /**
     * Set repsonse to be sent without errors
     * @return ValidationService
     */
    public function request(array $request): ValidationService;

    /**
     * Create a new Validator instance.
     *
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function make(array $rules, array $messages = [], array $customAttributes = []);
}
