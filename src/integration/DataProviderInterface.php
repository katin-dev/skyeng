<?php

namespace src\integration;

interface DataProviderInterface
{
    public function requestData(array $request);
}