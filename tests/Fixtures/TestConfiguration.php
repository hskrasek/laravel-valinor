<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Tests\Fixtures;

use HSkrasek\LaravelValinor\Config\Configuration as BaseConfiguration;

class TestConfiguration extends BaseConfiguration
{
    public static function mapping(): array
    {
        return [
            'app' => BaseConfiguration\App::class,
        ];
    }
}
