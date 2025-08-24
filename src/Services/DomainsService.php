<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Services;

use TdsSo\Sdk\Builders\CheckDomainsBuilder;
use TdsSo\Sdk\Responses\ApiResponse;
use TdsSo\Sdk\Responses\DomainsResponse;

class DomainsService extends AbstractService
{
    /**
     * Get user domains.
     *
     * @param int|null    $templateId   Filter by template ID
     * @param string|null $templateName Filter by template name
     */
    public function getDomains(?int $templateId = null, ?string $templateName = null): DomainsResponse
    {
        $params = [];

        if ($templateId !== null) {
            $params['template_id'] = $templateId;
        } elseif ($templateName !== null) {
            $params['template_name'] = $templateName;
        }

        $response = $this->httpClient->get('get/domains', $params);

        return new DomainsResponse($response);
    }

    /**
     * Check domains for availability and bans.
     *
     * @param string|array             $domains Comma-separated string or array of domains
     * @param CheckDomainsBuilder|null $builder Check options builder
     */
    public function checkDomains($domains, ?CheckDomainsBuilder $builder = null): ApiResponse
    {
        if ($builder === null) {
            $builder = new CheckDomainsBuilder();
        }

        $params = $builder->build();

        if (\is_array($domains)) {
            $domains = implode(',', $domains);
        }

        $params['domains_list'] = $domains;

        $response = $this->httpClient->get('domains/check', $params);

        return new ApiResponse($response);
    }

    /**
     * Check current active domains.
     *
     * @param CheckDomainsBuilder|null $builder Check options builder
     */
    public function checkCurrentDomains(?CheckDomainsBuilder $builder = null): ApiResponse
    {
        return $this->checkDomains('current', $builder);
    }

    /**
     * Delete domains.
     *
     * @param string|array $domains Comma-separated string or array of domains, or 'all'
     * @param bool         $soft    Soft delete (true) or force delete (false)
     * @param int|null     $limit   Maximum number of domains to delete
     */
    public function deleteDomains($domains, bool $soft = true, ?int $limit = null): ApiResponse
    {
        $params = ['soft' => $soft];

        if (\is_array($domains)) {
            $domains = implode(',', $domains);
        }

        $params['domains_list'] = $domains;

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        $response = $this->httpClient->get('domains/delete', $params);

        return new ApiResponse($response);
    }

    /**
     * Delete all domains.
     *
     * @param bool     $soft  Soft delete (true) or force delete (false)
     * @param int|null $limit Maximum number of domains to delete
     */
    public function deleteAllDomains(bool $soft = true, ?int $limit = null): ApiResponse
    {
        return $this->deleteDomains('all', $soft, $limit);
    }

    /**
     * Clear domain check cache.
     *
     * @param string|array|null $domains Specific domains to clear, or null/'all' to clear all
     */
    public function clearCache($domains = null): ApiResponse
    {
        $params = [];

        if ($domains === null || $domains === 'all') {
            $params['domains_list'] = 'all';
        } else {
            if (\is_array($domains)) {
                $domains = implode(',', $domains);
            }
            $params['domains_list'] = $domains;
        }

        $response = $this->httpClient->get('domains/clear-cache', $params);

        return new ApiResponse($response);
    }

    /**
     * Clear all domain check cache for current user.
     */
    public function clearAllCache(): ApiResponse
    {
        return $this->clearCache('all');
    }
}
