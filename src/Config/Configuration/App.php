<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Config\Configuration;

use HSkrasek\LaravelValinor\Config\Configuration;

class App extends Configuration
{
    public function __construct(
        public string $name,
        public string $env,
        public bool $debug,
        public string $url,
        public string $timezone,
        public string $locale,
        public string $fallbackLocale,
        public string $fakerLocale,
        public string $cipher,
        public string $key,
        /** @var string[] $previousKeys */
        public array $previousKeys,
        public Maintenance $maintenance,
    ) {}
}
