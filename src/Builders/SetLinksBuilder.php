<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Builders;

class SetLinksBuilder
{
    /**
     * @var array
     */
    private $params = [];

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
