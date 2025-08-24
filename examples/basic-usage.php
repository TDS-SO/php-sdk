<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TdsSo\Sdk\Exceptions\ApiException;
use TdsSo\Sdk\TdsSoClient;

// Инициализация клиента
$apiToken = 'your_64_character_api_token_here';
$client = new TdsSoClient($apiToken);

try {
    // Пример 1: Получение списка ссылок
    echo "=== Получение ссылок ===\n";
    $linksResponse = $client->links()->getLinks(10);

    foreach ($linksResponse->getLinks() as $link) {
        echo sprintf(
            "Ссылка: %s -> %s | Клики: %d (уникальные: %d)\n",
            $link->getLinkRedirect(),
            $link->getRedirectTo(),
            $link->getTotalClicks(),
            $link->getUniqueClicks()
        );
    }

    echo "\nОбщая статистика:\n";
    echo 'Всего кликов: ' . $linksResponse->getTotalClicks() . "\n";
    echo 'Уникальных кликов: ' . $linksResponse->getUniqueClicks() . "\n";
    echo 'Кликов с мобильных: ' . $linksResponse->getMobileClicks() . "\n";
    echo 'Кликов от ботов: ' . $linksResponse->getBotClicks() . "\n";

    // Пример 2: Получение доменов
    echo "\n=== Получение доменов ===\n";
    $domainsResponse = $client->domains()->getDomains();

    foreach ($domainsResponse->getDomains() as $domain) {
        $status = $domain->isPlugged() ? 'Активен' : 'Неактивен';
        $banned = $domain->isVkBanned() ? ' (Забанен ВК)' : '';

        echo sprintf(
            "Домен: %s | Статус: %s%s | Ссылок: %d\n",
            $domain->getDomain(),
            $status,
            $banned,
            $domain->getLinksCount()
        );
    }

    echo "\nАктивных доменов: " . count($domainsResponse->getActiveDomains()) . "\n";
    echo 'Забаненных доменов: ' . count($domainsResponse->getBannedDomains()) . "\n";

    // Пример 3: Получение шаблонов
    echo "\n=== Получение шаблонов ===\n";
    $templatesResponse = $client->templates()->getTemplates();

    foreach ($templatesResponse->getTemplates() as $template) {
        echo sprintf(
            "Шаблон: %s (ID: %d) | Тип редиректа: %s | Задержка: %d сек\n",
            $template->getName(),
            $template->getId(),
            $template->getRedirectType(),
            $template->getDelay() ?? 0
        );
    }

    // Пример 4: Обновление редиректа для последней ссылки
    echo "\n=== Обновление редиректа ===\n";
    $updateResponse = $client->links()->setLastLink('https://new-target.example.com');

    if ($updateResponse->get('response') === 'OK') {
        echo "Редирект успешно обновлен!\n";
        echo 'Новый редирект: ' . $updateResponse->get('new_redirect') . "\n";
        echo 'Обновлено ссылок: ' . $updateResponse->get('updated_count') . "\n";
    }
} catch (ApiException $e) {
    echo "\n!!! Ошибка API !!!\n";
    echo 'Сообщение: ' . $e->getMessage() . "\n";
    echo 'Код ошибки: ' . $e->getErrorId() . "\n";

    // Детальная информация об ошибке
    $responseData = $e->getResponseData();
    if (!empty($responseData)) {
        echo "Дополнительная информация:\n";
        print_r($responseData);
    }
} catch (Exception $e) {
    echo "\n!!! Общая ошибка !!!\n";
    echo 'Сообщение: ' . $e->getMessage() . "\n";
    echo 'Файл: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
