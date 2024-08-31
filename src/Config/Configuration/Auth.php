<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Config\Configuration;

use HSkrasek\LaravelValinor\Config\Configuration;

class Auth extends Configuration
{
    public function __construct(
        public array $defaults,
        public array $guards,
        public array $providers,
        public array $passwords,
        public int $passwordTimeout
    ) {}
}
