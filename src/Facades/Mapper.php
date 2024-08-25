<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Facades;

use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @see \CuyZ\Valinor\Mapper\TreeMapper
 */
class Mapper extends Facade
{
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'valinor.mapper';
    }
}
