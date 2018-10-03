<?php

namespace src\integration;

use Psr\Log\LoggerInterface;

abstract class DataProviderDecorator implements DataProviderInterface
{
    /** @var DataProviderInterface  */
    protected $dataProvider;

    /** @var LoggerInterface  */
    protected $logger;

    public function __construct(DataProviderInterface $dataProvider, LoggerInterface $logger)
    {
        $this->dataProvider = $dataProvider;
        $this->logger       = $logger;
    }

    public function requestData(array $request)
    {
        return $this->dataProvider->requestData($request);
    }
}