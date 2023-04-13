<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ErrorException extends Exception
{
    protected $message;
    protected $code;
    protected array $error;
    protected array $data;

    /**
     * @param string $message
     * @param int $code
     * @param array $error
     * @param array $data
     * @param Throwable|null $previous
     */
    public function  __construct(string $message = "Server Error", int $code = 0, array $error = [], array $data = [], ?Throwable $previous = null)
    {
        $this->data = $data;
        $this->error = $error;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(): \Illuminate\Http\JsonResponse
    {
        return error($this->message, $this->error, $this->code)->data($this->data)->response();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }
}
