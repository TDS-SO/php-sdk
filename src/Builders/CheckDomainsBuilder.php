<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Builders;

class CheckDomainsBuilder
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * Enable Google ban check.
     */
    public function checkGoogle(bool $check = true): self
    {
        $this->params['check_google'] = $check;

        return $this;
    }

    /**
     * Enable Yandex ban check.
     */
    public function checkYandex(bool $check = true): self
    {
        $this->params['check_yandex'] = $check;

        return $this;
    }

    /**
     * Enable VK ban check.
     */
    public function checkVk(bool $check = true): self
    {
        $this->params['check_vk'] = $check;

        return $this;
    }

    /**
     * Delete invalid domains after check.
     */
    public function deleteInvalid(bool $delete = true): self
    {
        $this->params['delete_invalid'] = $delete;

        return $this;
    }

    /**
     * Set note for domains.
     */
    public function setNote(string $note): self
    {
        $this->params['note'] = $note;

        return $this;
    }

    /**
     * Generate selling keys for domains.
     */
    public function generateKeys(bool $generate = true): self
    {
        $this->params['generate_keys'] = $generate;

        return $this;
    }

    /**
     * Give domains to another user.
     */
    public function giveDomains(string $userEmail): self
    {
        $this->params['give_domain'] = $userEmail;

        return $this;
    }

    /**
     * Disable cache usage for this check.
     */
    public function setNoCache(bool $noCache = true): self
    {
        $this->params['no_cache'] = $noCache;

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
