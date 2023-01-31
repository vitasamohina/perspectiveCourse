<?php

namespace Samohina\CityByIp\Api;

interface GeolocationServiceInterface
{
    public function getCityByIp(): string;
}
