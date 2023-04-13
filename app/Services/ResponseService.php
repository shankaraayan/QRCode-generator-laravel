<?php

namespace App\Services;

use App\Interfaces\ResponseInterface;

class ResponseService implements ResponseInterface
{
    protected string $message = '';
    protected int $statusCode = 200;
    protected array|object $data = [];
    protected array|object $errors  = [];

    function __construct(int $statusCode = null, string $message = null, array|object $data = null, array|object $errors = null)
    {
        $data && $this->data = $data;
        $errors && $this->errors = $errors;
        $message && $this->message = $message;
        $statusCode && $this->statusCode = $statusCode;
    }

    public function statusCode(int $code): ResponseService
    {
        $this->statusCode = $code;
        return $this;
    }

    public function data(array|object $data): ResponseService
    {
        $this->data = $data;
        return $this;
    }

    public function message(string $message): ResponseService
    {
        $this->message = $message;
        return $this;
    }

    public function errors(array|object $errors): ResponseService
    {
        $this->errors = $errors;
        return $this;
    }

    public function abort(): void
    {
        abort($this->response());
    }

    public function response(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $this->statusCode == 200 ? true : false,
            'message' => $this->message,
            'errors' => $this->errors,
            'data' => $this->data,
        ], $this->statusCode);
    }
}
