<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Responses;

class CreateResponse extends ApiResponse
{
    /**
     * Get response text.
     */
    public function getResponse(): ?array
    {
        return $this->get('response');
    }

    /**
     * Get operation log.
     */
    public function getLog(): ?array
    {
        return $this->get('log');
    }

    /**
     * Get created template info.
     */
    public function getTemplate(): ?array
    {
        return $this->getPath('response.template');
    }

    /**
     * Get template ID.
     */
    public function getTemplateId(): ?int
    {
        return $this->getPath('response.template.id');
    }

    /**
     * Get template name.
     */
    public function getTemplateName(): ?string
    {
        return $this->getPath('response.template.name');
    }
}
