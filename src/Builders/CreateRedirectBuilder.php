<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Builders;

class CreateRedirectBuilder
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * Set template ID or selector
     * Values: numeric ID, 'last', 'first', 'random', or template name.
     *
     * @param string|int $template
     */
    public function setTemplate($template): self
    {
        $this->params['template'] = $template;

        return $this;
    }

    /**
     * Set one-to-one redirect mode.
     */
    public function setHasOne(bool $hasOne = true): self
    {
        $this->params['has_one'] = $hasOne;

        return $this;
    }

    /**
     * Disable domain validation check.
     */
    public function withoutDomainChecking(): self
    {
        $this->params['no_check'] = 1;

        return $this;
    }

    /**
     * Enable VK ban check.
     */
    public function setCheckVk(bool $checkVk = true): self
    {
        $this->params['check_vk'] = $checkVk;

        return $this;
    }

    /**
     * Disable cache usage for domain checking.
     */
    public function setNoCache(bool $noCache = true): self
    {
        $this->params['no_cache'] = $noCache;

        return $this;
    }

    /**
     * Set link expiration date and time.
     */
    public function setExpiredAt(string $expiredAt): self
    {
        $this->params['expired_at'] = $expiredAt;

        return $this;
    }

    /**
     * Set folder for organizing links.
     */
    public function setFolder(string $folder): self
    {
        $this->params['folder'] = $folder;

        return $this;
    }

    /**
     * Build parameters array.
     */
    public function build(): array
    {
        return $this->params;
    }
}
