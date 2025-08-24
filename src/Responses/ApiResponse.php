<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Responses;

class ApiResponse
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get raw response data.
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Get specific field from response.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Check if response has specific key.
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Get response field from nested structure.
     *
     * @param string $path    Dot notation path (e.g., 'response.template.id')
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getPath(string $path, $default = null)
    {
        $keys = explode('.', $path);
        $value = $this->data;

        foreach ($keys as $key) {
            if (!\is_array($value) || !\array_key_exists($key, $value)) {
                return $default;
            }
            $value = $value[$key];
        }

        return $value;
    }
}
