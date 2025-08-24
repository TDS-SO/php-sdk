<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Services;

use TdsSo\Sdk\Builders\ExtendLinksBuilder;
use TdsSo\Sdk\Builders\SetLinksBuilder;
use TdsSo\Sdk\Responses\ApiResponse;
use TdsSo\Sdk\Responses\LinksResponse;

class LinksService extends AbstractService
{
    /**
     * Get user links.
     *
     * @param int    $offset Number of links to retrieve (default: 20)
     * @param string $order  Sort order: DESC or ASC (default: DESC)
     */
    public function getLinks(int $offset = 20, string $order = 'DESC'): LinksResponse
    {
        $params = [
            'offset' => $offset,
            'order'  => $order,
        ];

        $response = $this->httpClient->get('get/links', $params);

        return new LinksResponse($response);
    }

    /**
     * Update redirect URL for links.
     *
     * @param string               $redirectLink New redirect URL
     * @param SetLinksBuilder|null $builder      Filter builder
     */
    public function setLinks(string $redirectLink, ?SetLinksBuilder $builder = null): ApiResponse
    {
        if ($builder === null) {
            $builder = new SetLinksBuilder();
        }

        $params = $builder->build();
        $params['redirect_link'] = $redirectLink;

        $response = $this->httpClient->get('set/links', $params);

        return new ApiResponse($response);
    }

    /**
     * Update redirect for the last created link.
     *
     * @param string $redirectLink New redirect URL
     */
    public function setLastLink(string $redirectLink): ApiResponse
    {
        $builder = (new SetLinksBuilder())->setLink('last');

        return $this->setLinks($redirectLink, $builder);
    }

    /**
     * Update redirect for all links.
     *
     * @param string $redirectLink New redirect URL
     */
    public function setAllLinks(string $redirectLink): ApiResponse
    {
        $builder = (new SetLinksBuilder())->setLink('all');

        return $this->setLinks($redirectLink, $builder);
    }

    /**
     * Update redirect for links by template ID.
     *
     * @param string $redirectLink New redirect URL
     * @param int    $templateId   Template ID
     */
    public function setLinksByTemplateId(string $redirectLink, int $templateId): ApiResponse
    {
        $builder = (new SetLinksBuilder())->setTemplateId($templateId);

        return $this->setLinks($redirectLink, $builder);
    }

    /**
     * Update redirect for links by template name.
     *
     * @param string $redirectLink New redirect URL
     * @param string $templateName Template name
     */
    public function setLinksByTemplateName(string $redirectLink, string $templateName): ApiResponse
    {
        $builder = (new SetLinksBuilder())->setTemplateName($templateName);

        return $this->setLinks($redirectLink, $builder);
    }

    /**
     * Update redirect for links by folder.
     *
     * @param string $redirectLink New redirect URL
     * @param string $folder       Domain folder name
     */
    public function setLinksByFolder(string $redirectLink, string $folder): ApiResponse
    {
        $builder = (new SetLinksBuilder())->setFolder($folder);

        return $this->setLinks($redirectLink, $builder);
    }

    /**
     * Update redirect for links by group.
     *
     * @param string $redirectLink New redirect URL
     * @param string $group        Link group name
     */
    public function setLinksByGroup(string $redirectLink, string $group): ApiResponse
    {
        $builder = (new SetLinksBuilder())->setGroup($group);

        return $this->setLinks($redirectLink, $builder);
    }

    /**
     * Extend links lifetime.
     *
     * @param ExtendLinksBuilder|null $builder Filter and options builder
     */
    public function extendLinks(?ExtendLinksBuilder $builder = null): ApiResponse
    {
        if ($builder === null) {
            $builder = new ExtendLinksBuilder();
        }

        $params = $builder->build();

        $response = $this->httpClient->get('set/extend', $params);

        return new ApiResponse($response);
    }

    /**
     * Extend lifetime for all links.
     *
     * @param int  $hours      Number of hours to extend (default: 24)
     * @param bool $reactivate Reactivate inactive links (default: true)
     */
    public function extendAllLinks(int $hours = 24, bool $reactivate = true): ApiResponse
    {
        $builder = (new ExtendLinksBuilder())
            ->setLink('all')
            ->setHours($hours)
            ->setReactivate($reactivate)
        ;

        return $this->extendLinks($builder);
    }

    /**
     * Extend lifetime for links by template.
     *
     * @param int  $templateId Template ID
     * @param int  $hours      Number of hours to extend (default: 24)
     * @param bool $reactivate Reactivate inactive links (default: true)
     */
    public function extendLinksByTemplateId(int $templateId, int $hours = 24, bool $reactivate = true): ApiResponse
    {
        $builder = (new ExtendLinksBuilder())
            ->setTemplateId($templateId)
            ->setHours($hours)
            ->setReactivate($reactivate)
        ;

        return $this->extendLinks($builder);
    }

    /**
     * Extend lifetime for links by folder.
     *
     * @param string $folder     Domain folder name
     * @param int    $hours      Number of hours to extend (default: 24)
     * @param bool   $reactivate Reactivate inactive links (default: true)
     */
    public function extendLinksByFolder(string $folder, int $hours = 24, bool $reactivate = true): ApiResponse
    {
        $builder = (new ExtendLinksBuilder())
            ->setFolder($folder)
            ->setHours($hours)
            ->setReactivate($reactivate)
        ;

        return $this->extendLinks($builder);
    }
}
