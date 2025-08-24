<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Responses;

use TdsSo\Sdk\ValueObjects\Domain;

class DomainsResponse extends ApiResponse
{
    /**
     * Get domains collection.
     *
     * @return Domain[]
     */
    public function getDomains(): array
    {
        $domains = $this->getPath('response.domains', []);

        return array_map(static function (array $domainData) {
            return new Domain($domainData);
        }, $domains);
    }

    /**
     * Get domains count.
     */
    public function count(): int
    {
        return \count($this->getDomains());
    }

    /**
     * Get active domains (plugged and not banned).
     *
     * @return Domain[]
     */
    public function getActiveDomains(): array
    {
        return array_filter($this->getDomains(), static function (Domain $domain) {
            return $domain->isPlugged() && !$domain->isVkBanned();
        });
    }

    /**
     * Get banned domains.
     *
     * @return Domain[]
     */
    public function getBannedDomains(): array
    {
        return array_filter($this->getDomains(), static function (Domain $domain) {
            return $domain->isVkBanned();
        });
    }

    /**
     * Get owned domains.
     *
     * @return Domain[]
     */
    public function getOwnedDomains(): array
    {
        return array_filter($this->getDomains(), static function (Domain $domain) {
            return $domain->isOwned();
        });
    }
}
