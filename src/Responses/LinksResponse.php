<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Responses;

use TdsSo\Sdk\ValueObjects\Link;

class LinksResponse extends ApiResponse
{
    /**
     * Get links collection.
     *
     * @return Link[]
     */
    public function getLinks(): array
    {
        $links = $this->getPath('response.links', []);

        return array_map(static function (array $linkData) {
            return new Link($linkData);
        }, $links);
    }

    /**
     * Get full statistics.
     */
    public function getFullStats(): array
    {
        return $this->get('full_stat', [
            'full_clicks'   => 0,
            'unique_clicks' => 0,
            'bots_clicks'   => 0,
            'mobile_clicks' => 0,
        ]);
    }

    /**
     * Get total clicks count.
     */
    public function getTotalClicks(): int
    {
        return (int) ($this->getFullStats()['full_clicks'] ?? 0);
    }

    /**
     * Get unique clicks count.
     */
    public function getUniqueClicks(): int
    {
        return (int) ($this->getFullStats()['unique_clicks'] ?? 0);
    }

    /**
     * Get bot clicks count.
     */
    public function getBotClicks(): int
    {
        return (int) ($this->getFullStats()['bots_clicks'] ?? 0);
    }

    /**
     * Get mobile clicks count.
     */
    public function getMobileClicks(): int
    {
        return (int) ($this->getFullStats()['mobile_clicks'] ?? 0);
    }
}
