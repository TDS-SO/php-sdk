<?php

declare(strict_types=1);

namespace TdsSo\Sdk\ValueObjects;

class Template
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
     * Get template ID.
     */
    public function getId(): ?int
    {
        return isset($this->data['id']) ? (int) $this->data['id'] : null;
    }

    /**
     * Get template name.
     */
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    /**
     * Get bot list.
     */
    public function getBotList(): array
    {
        return $this->data['bot_list'] ?? [];
    }

    /**
     * Get redirect type.
     */
    public function getRedirectType(): ?string
    {
        return $this->data['redirect_type'] ?? null;
    }

    /**
     * Get minimum symbols.
     */
    public function getMinSymbols(): ?int
    {
        return isset($this->data['min_symbols']) ? (int) $this->data['min_symbols'] : null;
    }

    /**
     * Get maximum symbols.
     */
    public function getMaxSymbols(): ?int
    {
        return isset($this->data['max_symbols']) ? (int) $this->data['max_symbols'] : null;
    }

    /**
     * Check if random phrases enabled.
     */
    public function hasRandomPhrases(): bool
    {
        return (bool) ($this->data['random_phrazes'] ?? false);
    }

    /**
     * Check if ban check enabled.
     */
    public function hasBanCheck(): bool
    {
        return (bool) ($this->data['ban_check'] ?? false);
    }

    /**
     * Get user agent bots.
     */
    public function getUseragentBots(): ?array
    {
        return $this->data['useragent_bots'] ?? null;
    }

    /**
     * Check if button/plug enabled.
     */
    public function hasButton(): bool
    {
        return (bool) ($this->data['button'] ?? false);
    }

    /**
     * Get redirect delay.
     */
    public function getDelay(): ?int
    {
        return isset($this->data['delay']) ? (int) $this->data['delay'] : null;
    }

    /**
     * Get hours before auto delete.
     */
    public function getHoursDelete(): ?int
    {
        return isset($this->data['hours_delete']) ? (int) $this->data['hours_delete'] : null;
    }

    /**
     * Convert to array.
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
