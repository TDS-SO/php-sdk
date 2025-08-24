<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Exceptions;

class ApiException extends \RuntimeException
{
    /**
     * @var int|null
     */
    private $errorId;

    /**
     * @var array
     */
    private $responseData;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?int $errorId = null,
        array $responseData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errorId = $errorId;
        $this->responseData = $responseData;
    }

    /**
     * Get error ID from API response.
     */
    public function getErrorId(): ?int
    {
        return $this->errorId;
    }

    /**
     * Get full response data.
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * Create exception from API response.
     */
    public static function fromResponse(array $response, int $httpCode = 400): self
    {
        $message = $response['error'] ?? 'Unknown API error';
        if (\is_array($message)) {
            $message = json_encode($message);
        }

        $errorId = isset($response['error_id']) ? (int) $response['error_id'] : null;

        return new self($message, $httpCode, $errorId, $response);
    }
}
