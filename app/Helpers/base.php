<?php

use App\Services\ValidationService;
use App\Services\ResponseService;

//Rules

if (!function_exists('validate')) {
    /**
     * Create a custom Validator instance.
     *
     * @return \App\Services\ValidationService
     */
    function validate()
    {
        return app(ValidationService::class);
    }
}


if (!function_exists('success')) {
    /**
     * Create a custom Error handler instance.
     * @param string $message
     * @param array|object $data
     * @param int $statusCode
     * @param array|object $errors
     * @return \App\Services\ResponseService
     */
    function success(string $message = "", array|object $data = [], int $statusCode = 200, array|object $errors = [])
    {
        return app(ResponseService::class, ['statusCode' => $statusCode, 'message' => $message, 'data' => $data, 'errors' => $errors]);
    }
}

if (!function_exists('error')) {
    /**
     * Create a custom Error handler instance.
     * @param string $message
     * @param array|object $errors
     * @param int $statusCode
     * @param array|object $data
     * @return \App\Services\ResponseService
     */
    function error(string $message = "Server Error", array|object $errors = [], int $statusCode = 500, array|object $data = [])
    {
        return app(ResponseService::class, ['statusCode' => $statusCode, 'message' => $message, 'data' => $data, 'errors' => $errors]);
    }
}


if (!function_exists('isAssoc')) {
    /**
     * Determine is an array associative?
     * @param array $arr
     * @return bool
     */
    function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (!function_exists('parseContent')) {
    /** Used to parse content in Html template
     * @param string $template
     * @param array $data
     * @return string|array|string[]|null
     */
    function parseContent(string $template, array $data): string|array|null
    {
        return preg_replace_callback('/{{\$(.*?)}}/', function ($matches) use ($data) {
            list($param, $index) = $matches;
            if (isset($data[$index])) {
                return $data[$index];
            }
            return null;
        }, $template);
    }
}

if (!function_exists('randomString')) {
    /** Used to generate random string
     * @param int $length
     * @return string
     */
    function randomString(int $length): string
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}
