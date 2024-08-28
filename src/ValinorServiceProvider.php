<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor;

use Carbon\Carbon;
use CuyZ\Valinor\Mapper\ArgumentsMapper;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use DateTimeInterface;
use HSkrasek\LaravelValinor\Http\ParsedRequest;
use Illuminate\Contracts\Foundation\Application;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Throwable;

class ValinorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-valinor')
            ->hasConfigFile()
            ->hasInstallCommand(
                fn (InstallCommand $command): InstallCommand => $command
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('hskrasek/laravel-valinor')
            );
    }

    public function packageBooted(): void
    {
        $this->app->singletonIf(MapperBuilder::class, function (Application $app): MapperBuilder {
            // TODO: I could "dog food" this into a typed object
            $config = $app->make('config')->get('valinor');
            $builder = new MapperBuilder;

            //TODO: This builder construction feels clunky
            if ($config['flexible_casting']) {
                $builder = $builder->enableFlexibleCasting();
            }

            if ($config['superfluous_casting']) {
                $builder = $builder->allowSuperfluousKeys();
            }

            if ($config['permissive_casting']) {
                $builder = $builder->allowPermissiveTypes();
            }

            if (! empty($config['supported_date_formats'])) {
                $builder = $builder->supportDateFormats(...$config['supported_date_formats']);
            }

            return $builder
                ->infer(name: DateTimeInterface::class, callback: fn () => $config['datetime_class'])
                // TODO: Extract these both to invokable classes
                ->registerConstructor(function (string $time): Carbon {
                    return Carbon::parse($time);
                })
                ->filterExceptions(function (Throwable $exception) {
                    if ($exception instanceof \Carbon\Exceptions\Exception) {
                        return \CuyZ\Valinor\Mapper\Tree\Message\MessageBuilder::from($exception);
                    }

                    throw $exception;
                });
        });

        $this->app->singleton(
            abstract: TreeMapper::class,
            concrete: fn (Application $app): TreeMapper => $app->make(MapperBuilder::class)
                ->mapper()
        );

        $this->app->singleton(
            abstract: ArgumentsMapper::class,
            concrete: fn (Application $app): ArgumentsMapper => $app->make(MapperBuilder::class)
                ->argumentsMapper()
        );

        $this->app->alias(TreeMapper::class, 'valinor.mapper');
        $this->app->alias(ArgumentsMapper::class, 'valinor.arguments.mapper');

        $this->app->beforeResolving(
            abstract: ParsedRequest::class,
            callback: function (string $abstract, array $parameters, Application $app) {
                $app->bind($abstract, function (Application $app) use ($abstract) {
                    return $app[TreeMapper::class]
                        ->map(
                            signature: $abstract,
                            source: $app['request']->input(),
                        );
                });
            },
        );
    }

    /**
     * @return array<string|class-string>
     */
    public function provides(): array
    {
        return [
            'valinor.mapper',
            'valinor.arguments.mapper',
            MapperBuilder::class,
            TreeMapper::class,
            ArgumentsMapper::class,
        ];
    }
}
