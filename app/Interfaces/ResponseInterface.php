<?php

namespace App\Interfaces;

use App\Services\ResponseService;

interface ResponseInterface
{
    /**
     * Set custom status code for reponse.
     * @return ResponseService
     */
    public function statusCode(int $code): ResponseService;

    /**
     * Set custom message to the response.
     * @param array $message
     * @return ResponseService
     */
    public function message(string $message): ResponseService;

    /**
     * Set custom data to the response.
     * @param array $data
     * @return ResponseService
     */
    public function data(array|object $data): ResponseService;

    /**
     * Set custom error to the response.
     * @param array $errors
     * @return ResponseService
     */
    public function errors(array|object $errors): ResponseService;
}
