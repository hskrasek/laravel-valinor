<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor;

use CuyZ\Valinor\MapperBuilder;
use Illuminate\Support\ServiceProvider;

class ValinorApplicationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->afterResolving(MapperBuilder::class, function (MapperBuilder $builder) {
            if (! empty($constructors = $this->registerConstructors())) {
                $builder->registerConstructor(...$constructors);
            }
        });
    }

    /**
     * @phpstan-return list|non-empty-list<class-string|callable>
     */
    protected function registerConstructors(): array
    {
        return [];
    }
}
