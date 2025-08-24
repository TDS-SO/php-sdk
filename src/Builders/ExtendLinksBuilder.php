<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Builders;

class ExtendLinksBuilder
{
    /**
     * @var array
     */
    private $params = [];

    /**
     * Set hours to extend link lifetime.
     *
     * @param int $hours Number of hours (1-8760)
     */
    public function setHours(int $hours): self
    {
        $this->params['hours'] = $hours;

        return $this;
    }

    /**
     * Set whether to reactivate inactive links.
     */
    public function setReactivate(bool $reactivate): self
    {
        $this->params['reactivate'] = $reactivate;

        return $this;
    }

    /**
     * Set link filter
     * Values: specific link/domain/unique_phraze, 'last', 'first', 'all'.
     */
    public function setLink(string $link): self
    {
        $this->params['link'] = $link;

        return $this;
    }

    /**
     * Set template ID filter.
     */
    public function setTemplateId(int $templateId): self
    {
        $this->params['template_id'] = $templateId;

        return $this;
    }

    /**
     * Set template name filter.
     */
    public function setTemplateName(string $templateName): self
    {
        $this->params['template_name'] = $templateName;

        return $this;
    }

    /**
     * Set folder filter (for domains).
     */
    public function setFolder(string $folder): self
    {
        $this->params['folder'] = $folder;

        return $this;
    }

    /**
     * Set group filter (for links).
     */
    public function setGroup(string $group): self
    {
        $this->params['group'] = $group;

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
