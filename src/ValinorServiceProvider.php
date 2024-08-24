<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor;

use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use HSkrasek\LaravelValinor\Contracts\ParsesWhenResolved;
use HSkrasek\LaravelValinor\Http\FormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

class ValinorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(
            abstract: TreeMapper::class,
            concrete: fn (Application $app): TreeMapper => (new MapperBuilder)
                ->mapper()
        );
    }
}
