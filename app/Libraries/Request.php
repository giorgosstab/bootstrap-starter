<?php

namespace App\Libraries;

class Request
{
    protected mixed $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return strtoupper($this->method);
    }

    /**
     * @param string $method
     * @return bool
     */
    public function isMethod(string $method): bool
    {
        return strtoupper($this->method) === strtoupper($method);
    }

    /**
     * @param string|null $key
     * @param $default
     * @return array|mixed|null
     */
    public function get(string $key = null, $default = null): mixed
    {
        if ($key === null) {
            return array_merge($_GET, $_POST);
        }

        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    /**
     * @return array|mixed|null
     */
    public function all(): mixed
    {
        return $this->get();
    }

    /**
     * @param string|null $key
     * @param $default
     * @return array|mixed|null
     */
    public function __invoke(string $key = null, $default = null): mixed
    {
        return $this->get($key, $default);
    }
}