<?php

namespace src\integration\DataProvider;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use src\integration\DataProviderInterface;

class SomeGoodServiceDataProvider implements DataProviderInterface
{
    /** @var string */
    private $host;

    /** @var string */
    private $user;

    /** @var string */
    private $password;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param LoggerInterface|null $logger
     */
    public function __construct($host, $user, $password, LoggerInterface $logger = null)
    {
        $this->host     = $host;
        $this->user     = $user;
        $this->password = $password;
        $this->logger   = $logger;
    }

    /**
     * Получить данные от стороннего сервиса
     * @param array $request
     * @return array
     */
    public function requestData(array $request)
    {
        $this->log(LogLevel::INFO, 'New request', $request);
        $response = []; // some external response
        $this->log(LogLevel::INFO, 'Response', $response);

        return $response;
    }

    /**
     * Метод-обёртка для обеспечения логирования
     * @param string $level
     * @param string $message
     * @param array $context
     */
    private function log($level, $message, $context = [])
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }
}
