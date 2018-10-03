<?php

namespace src\integration\DataProviderDecorator;

use DateInterval;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use src\integration\DataProviderDecorator;
use src\integration\DataProviderInterface;

class CacheableDataProvider extends DataProviderDecorator
{
    /** @var CacheInterface */
    private $cache;

    public function __construct(DataProviderInterface $dataProvider, LoggerInterface $logger,  CacheInterface $cache)
    {
        parent::__construct($dataProvider, $logger);
        $this->cache = $cache;
    }

    public function requestData(array $request)
    {
        $cacheKey  = $this->getCacheKey($request);
        $cacheItem = null;

        // Если система кеширования отвалилась, то надо суметь продолжить работу без него.
        // Это моя додумка. На деле надо уточнять по задаче. Возможно, лучше упасть, чем работать без кеша в таком случае (чтоб сохранить деньги, например)
        try {
            $cacheItem = $this->cache->get($cacheKey, null);
            if ($cacheItem !== null) {
                return $cacheItem;
            }
        } catch (Exception $ex) {
            $this->logger->warning('Unable to get cache element', $request);
        }

        $result = parent::requestData($request);

        if ($cacheItem) {
            try {
                $this->cache->set($cacheKey, $cacheItem, new DateInterval('P1D'));
            } catch (Exception $ex) {
                $this->logger->warning('Unable to cache result', $result);
            }
        }

        return $result;
    }

    private function getCacheKey(array $request)
    {
        return md5(json_encode($request));
    }
}