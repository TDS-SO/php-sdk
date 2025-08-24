<?php

declare(strict_types=1);

namespace TdsSo\Sdk\ValueObjects;

class Link
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
     * Get redirect link.
     */
    public function getLinkRedirect(): ?string
    {
        return $this->data['link_redirect'] ?? null;
    }

    /**
     * Get redirect to URL.
     */
    public function getRedirectTo(): ?string
    {
        return $this->data['redirect_to'] ?? null;
    }

    /**
     * Get total clicks.
     */
    public function getTotalClicks(): int
    {
        return (int) ($this->data['total_clicks'] ?? 0);
    }

    /**
     * Get mobile clicks.
     */
    public function getMobileClicks(): int
    {
        return (int) ($this->data['mobile_clicks'] ?? 0);
    }

    /**
     * Get bot clicks.
     */
    public function getBotsClicks(): int
    {
        return (int) ($this->data['bots_clicks'] ?? 0);
    }

    /**
     * Get unique clicks.
     */
    public function getUniqueClicks(): int
    {
        return (int) ($this->data['unique_clicks'] ?? 0);
    }

    /**
     * Get creation time.
     */
    public function getCreatedTime(): ?string
    {
        return $this->data['created_time'] ?? null;
    }

    /**
     * Get creation time as DateTime.
     */
    public function getCreatedAt(): ?\DateTime
    {
        $time = $this->getCreatedTime();
        if ($time === null) {
            return null;
        }

        try {
            return new \DateTime($time);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Convert to array.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
