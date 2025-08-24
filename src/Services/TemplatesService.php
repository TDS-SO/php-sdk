<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Services;

use TdsSo\Sdk\Builders\TemplateBuilder;
use TdsSo\Sdk\Responses\CreateResponse;
use TdsSo\Sdk\Responses\TemplatesResponse;

class TemplatesService extends AbstractService
{
    /**
     * Get all templates.
     */
    public function getTemplates(): TemplatesResponse
    {
        $response = $this->httpClient->get('get/templates');

        return new TemplatesResponse($response);
    }

    /**
     * Get template by name.
     *
     * @param string $name Template name
     */
    public function getTemplateByName(string $name): TemplatesResponse
    {
        $response = $this->httpClient->get('get/templates', ['name' => $name]);

        return new TemplatesResponse($response);
    }

    /**
     * Create new template.
     *
     * @param TemplateBuilder $builder Template configuration builder
     */
    public function createTemplate(TemplateBuilder $builder): CreateResponse
    {
        $params = $builder->build();

        $response = $this->httpClient->get('create/template', $params);

        return new CreateResponse($response);
    }

    /**
     * Create simple template with default settings.
     *
     * @param string      $name        Template name
     * @param string|null $description Template description
     */
    public function createSimpleTemplate(string $name, ?string $description = null): CreateResponse
    {
        $builder = (new TemplateBuilder())
            ->setName($name)
        ;

        return $this->createTemplate($builder);
    }
}
