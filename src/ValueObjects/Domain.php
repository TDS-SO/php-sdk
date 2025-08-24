<?php

declare(strict_types=1);

namespace TdsSo\Sdk\ValueObjects;

class Domain
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get domain name.
     */
    public function getDomain(): ?string
    {
        return $this->data['domain'] ?? null;
    }

    /**
     * Check if domain is plugged.
     */
    public function isPlugged(): bool
    {
        return (bool) ($this->data['plug'] ?? false);
    }

    /**
     * Check if domain is VK banned.
     */
    public function isVkBanned(): bool
    {
        return (bool) ($this->data['banned'] ?? false);
    }

    /**
     * Check if domain is owned.
     */
    public function isOwned(): bool
    {
        return (bool) ($this->data['owned'] ?? false);
    }

    /**
     * Get selling key.
     */
    public function getSellingKey(): ?string
    {
        return $this->data['selling_key'] ?? null;
    }

    /**
     * Get links count.
     */
    public function getLinksCount(): int
    {
        return (int) ($this->data['link_count'] ?? 0);
    }

    /**
     * Convert to array.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
