<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Config\Configuration;

use HSkrasek\LaravelValinor\Config\Configuration;

class Maintenance extends Configuration
{
    public function __construct(
        public string $driver,
        public string $store,
    ) {}
}
