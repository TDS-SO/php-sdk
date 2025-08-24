# TDS.SO PHP SDK

Официальный PHP SDK для работы с API v2 TDS.SO - системы управления трафиком.

## Требования

- PHP 7.2 или выше
- Composer
- Guzzle HTTP Client 6.5+ или 7.0+

## Установка

```bash
composer require tds-so/php-sdk
```

## Быстрый старт

```php
<?php

use TdsSo\Sdk\TdsSoClient;

// Создание клиента
$client = new TdsSoClient('ваш_api_токен_64_символа');

// Или с дополнительными опциями
$client = new TdsSoClient('ваш_api_токен', [
    'base_uri' => 'https://tds.so/api/v2',
    'timeout' => 30,
    'debug' => false,
]);
```

## Основные возможности

### Работа с ссылками

```php
// Получить список ссылок
$response = $client->links()->getLinks(20, 'DESC');
$links = $response->getLinks();

foreach ($links as $link) {
    echo $link->getLinkRedirect() . ' -> ' . $link->getRedirectTo() . PHP_EOL;
    echo 'Клики: ' . $link->getTotalClicks() . PHP_EOL;
}

// Обновить редирект для последней ссылки
$client->links()->setLastLink('https://new-redirect.com');

// Обновить редирект для всех ссылок
$client->links()->setAllLinks('https://new-redirect.com');

// Обновить редирект с фильтрами
use TdsSo\Sdk\Builders\SetLinksBuilder;

$builder = (new SetLinksBuilder())
    ->setTemplateId(123)
    ->setFolder('my-folder');

$client->links()->setLinks('https://new-redirect.com', $builder);

// Продлить срок жизни ссылок
use TdsSo\Sdk\Builders\ExtendLinksBuilder;

// Продлить все ссылки на 48 часов и реактивировать неактивные
$response = $client->links()->extendAllLinks(hours: 48, reactivate: true);

// Продлить ссылки по шаблону
$response = $client->links()->extendLinksByTemplateId(123, hours: 72);

// Продлить ссылки по папке доменов
$response = $client->links()->extendLinksByFolder('active-domains', hours: 168);

// Продлить с кастомными фильтрами
$builder = (new ExtendLinksBuilder())
    ->setTemplateId(123)
    ->setFolder('my-folder')
    ->setHours(24)
    ->setReactivate(false); // Не реактивировать неактивные

$response = $client->links()->extendLinks($builder);
echo 'Продлено ссылок: ' . $response->get('extended_count');
echo 'Реактивировано: ' . $response->get('reactivated_count');
```

### Работа с доменами

```php
// Получить все домены
$response = $client->domains()->getDomains();
$domains = $response->getDomains();

// Получить домены по шаблону
$response = $client->domains()->getDomains(templateId: 123);

// Проверить домены
use TdsSo\Sdk\Builders\CheckDomainsBuilder;

$builder = (new CheckDomainsBuilder())
    ->checkVk(true)
    ->checkGoogle(true)
    ->deleteInvalid(true);

$response = $client->domains()->checkDomains(['domain1.com', 'domain2.com'], $builder);

// Проверить домены без использования кеша
$builder = (new CheckDomainsBuilder())
    ->setNoCache(true)
    ->checkVk(true);

$response = $client->domains()->checkDomains(['domain1.com', 'domain2.com'], $builder);

// Удалить домены
$client->domains()->deleteDomains(['old-domain.com'], soft: true);

// Удалить все домены
$client->domains()->deleteAllDomains(soft: false, limit: 100);

// Очистить кеш проверки доменов
$client->domains()->clearCache(['domain1.com', 'domain2.com']);

// Очистить весь кеш проверки доменов
$client->domains()->clearAllCache();
```

#### Кеширование при проверке доменов
API v2 автоматически кеширует результаты проверки валидных доменов на 10 минут. При повторной проверке тех же доменов в течение этого времени, они не будут проверяться повторно, что значительно ускоряет процесс и снижает нагрузку.

### Работа с шаблонами

```php
// Получить все шаблоны
$response = $client->templates()->getTemplates();
$templates = $response->getTemplates();

// Получить шаблон по имени
$response = $client->templates()->getTemplateByName('my-template');
$template = $response->getTemplate();

// Создать новый шаблон
use TdsSo\Sdk\Builders\TemplateBuilder;

$builder = (new TemplateBuilder())
    ->setName('New Template')
    ->setDescription('Created via SDK')
    ->setRedirectType('301')
    ->setRedirectDelay(3)
    ->setBanCheck(true)
    ->setRandomPhrases(true)
    ->setMinSymbols(5)
    ->setMaxSymbols(10);

$response = $client->templates()->createTemplate($builder);
echo 'Created template ID: ' . $response->getTemplateId();
```

### Создание редиректов

```php
use TdsSo\Sdk\Builders\CreateRedirectBuilder;

// Создать массовые редиректы
$domains = ['domain1.com', 'domain2.com'];
$links = ['https://target1.com', 'https://target2.com'];

$builder = (new CreateRedirectBuilder())
    ->setTemplate('last')
    ->setCheckVk(true);

$response = $client->create()->createRedirect($domains, $links, $builder);
echo $response->getResponse();

// Создать единичный редирект
$response = $client->create()->createSingleRedirect(
    'single-domain.com',
    'https://single-target.com'
);
```

## Обработка ошибок

```php
use TdsSo\Sdk\Exceptions\ApiException;
use TdsSo\Sdk\Exceptions\InvalidConfigurationException;

try {
    $response = $client->links()->getLinks();
} catch (ApiException $e) {
    // Ошибка API
    echo 'API Error: ' . $e->getMessage() . PHP_EOL;
    echo 'Error ID: ' . $e->getErrorId() . PHP_EOL;
    
    // Получить полный ответ
    $data = $e->getResponseData();
} catch (InvalidConfigurationException $e) {
    // Ошибка конфигурации
    echo 'Configuration Error: ' . $e->getMessage();
} catch (\Exception $e) {
    // Другие ошибки
    echo 'Error: ' . $e->getMessage();
}
```

## Расширенные возможности

### Пользовательский HTTP клиент

Вы можете использовать свою реализацию HTTP клиента:

```php
use TdsSo\Sdk\Contracts\HttpClientInterface;

class MyHttpClient implements HttpClientInterface
{
    public function get(string $endpoint, array $params = []): array
    {
        // Ваша реализация
    }
    
    // Остальные методы...
}

$client = new TdsSoClient('token', [
    'http_client' => new MyHttpClient(),
]);
```

### Пользовательская конфигурация

```php
use TdsSo\Sdk\Client\Configuration;
use TdsSo\Sdk\TdsSoClient;

$config = new Configuration(
    token: 'your_token',
    baseUri: 'https://custom.api.url/v2',
    timeout: 60,
    debug: true
);

$client = TdsSoClient::createWithConfig($config);
```

## Примеры использования

### Полный пример работы

```php
<?php

require 'vendor/autoload.php';

use TdsSo\Sdk\TdsSoClient;
use TdsSo\Sdk\Builders\TemplateBuilder;
use TdsSo\Sdk\Builders\CreateRedirectBuilder;
use TdsSo\Sdk\Builders\CheckDomainsBuilder;
use TdsSo\Sdk\Exceptions\ApiException;

$client = new TdsSoClient('your_api_token_here');

try {
    // 1. Создаем шаблон
    $templateBuilder = (new TemplateBuilder())
        ->setName('SDK Template ' . time())
        ->setDescription('Test template from SDK')
        ->setRedirectType('301')
        ->setBanCheck(true);
    
    $templateResponse = $client->templates()->createTemplate($templateBuilder);
    $templateId = $templateResponse->getTemplateId();
    echo "Created template: {$templateId}\n";
    
    // 2. Создаем редиректы
    $domains = ['test1.example.com', 'test2.example.com'];
    $links = ['https://target1.com', 'https://target2.com'];
    
    $redirectBuilder = (new CreateRedirectBuilder())
        ->setTemplate($templateId)
        ->setCheckVk(true);
    
    $redirectResponse = $client->create()->createRedirect($domains, $links, $redirectBuilder);
    echo "Redirects created: " . $redirectResponse->getResponse() . "\n";
    
    // 3. Проверяем домены
    $checkBuilder = (new CheckDomainsBuilder())
        ->checkVk(true)
        ->setNote('SDK Test');
    
    $checkResponse = $client->domains()->checkDomains($domains, $checkBuilder);
    echo "Domains checked\n";
    
    // 4. Получаем статистику
    $linksResponse = $client->links()->getLinks();
    echo "Total clicks: " . $linksResponse->getTotalClicks() . "\n";
    echo "Unique clicks: " . $linksResponse->getUniqueClicks() . "\n";
    
} catch (ApiException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
    echo "Error ID: " . $e->getErrorId() . "\n";
}
```

## Принципы SOLID

SDK следует принципам SOLID:

1. **Single Responsibility**: Каждый класс имеет одну ответственность
2. **Open/Closed**: Легко расширяется через интерфейсы
3. **Liskov Substitution**: Все реализации интерфейсов взаимозаменяемы
4. **Interface Segregation**: Узкие, специфичные интерфейсы
5. **Dependency Inversion**: Зависимость от абстракций, а не конкретных реализаций

## Лицензия

MIT License

## Поддержка

- Email: support@tds.so
- Documentation: https://docs.tds.so
