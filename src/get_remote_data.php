<?php

use Psr\Log\NullLogger;
use src\integration\DataProvider\SomeGoodServiceDataProvider;
use src\integration\DataProviderDecorator\CacheableDataProvider;
use Symfony\Component\Cache\Simple\NullCache;

$client = new SomeGoodServiceDataProvider('https://api.some-good-service.com', 'username', 'password', new NullLogger());
$client = new CacheableDataProvider($client, new NullLogger(), new NullCache());
$client->requestData([
    // ... some request params
]);