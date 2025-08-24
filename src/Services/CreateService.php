<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Services;

use TdsSo\Sdk\Builders\CreateRedirectBuilder;
use TdsSo\Sdk\Builders\TemplateBuilder;
use TdsSo\Sdk\Responses\CreateResponse;

class CreateService extends AbstractService
{
    /**
     * Create redirects.
     *
     * @param string|array               $redirectDomains Comma-separated string or array of domains
     * @param string|array               $linkLists       Comma-separated string or array of links
     * @param CreateRedirectBuilder|null $builder         Additional options
     */
    public function createRedirect($redirectDomains, $linkLists, ?CreateRedirectBuilder $builder = null): CreateResponse
    {
        if ($builder === null) {
            $builder = new CreateRedirectBuilder();
        }

        $params = $builder->build();

        if (\is_array($redirectDomains)) {
            $redirectDomains = implode(',', $redirectDomains);
        }

        if (\is_array($linkLists)) {
            $linkLists = implode(',', $linkLists);
        }

        $params['redirect_domains'] = $redirectDomains;
        $params['link_lists'] = $linkLists;

        $response = $this->httpClient->get('create/redirect', $params);

        return new CreateResponse($response);
    }

    /**
     * Create template.
     *
     * @param TemplateBuilder $builder Template configuration
     */
    public function createTemplate(TemplateBuilder $builder): CreateResponse
    {
        $params = $builder->build();

        $response = $this->httpClient->get('create/template', $params);

        return new CreateResponse($response);
    }

    /**
     * Create single redirect (one domain to one link).
     *
     * @param string                     $domain  Redirect domain
     * @param string                     $link    Target link
     * @param CreateRedirectBuilder|null $builder Additional options
     */
    public function createSingleRedirect(string $domain, string $link, ?CreateRedirectBuilder $builder = null): CreateResponse
    {
        if ($builder === null) {
            $builder = new CreateRedirectBuilder();
        }

        $builder->setHasOne(true);

        return $this->createRedirect($domain, $link, $builder);
    }
}
