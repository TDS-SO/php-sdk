<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Responses;

use TdsSo\Sdk\ValueObjects\Template;

class TemplatesResponse extends ApiResponse
{
    /**
     * Get templates collection.
     *
     * @return Template[]
     */
    public function getTemplates(): array
    {
        $templates = $this->getPath('response.templates', []);

        // Handle single template response
        if (isset($templates['id'])) {
            $templates = [$templates];
        }

        return array_map(static function (array $templateData) {
            return new Template($templateData);
        }, $templates);
    }

    /**
     * Get first template (for single template responses).
     */
    public function getTemplate(): ?Template
    {
        $templates = $this->getTemplates();

        return $templates[0] ?? null;
    }

    /**
     * Get templates count.
     */
    public function count(): int
    {
        return \count($this->getTemplates());
    }

    /**
     * Check if response contains single template.
     */
    public function isSingleTemplate(): bool
    {
        return $this->count() === 1;
    }
}
