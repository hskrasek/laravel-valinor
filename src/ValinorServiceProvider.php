<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor;

use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use DateTimeInterface;
use Illuminate\Contracts\Foundation\Application;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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

            if ($config['flexible_casting']) {
                $builder = $builder->enableFlexibleCasting();
            }

            if ($config['superfluous_casting']) {
                $builder = $builder->allowSuperfluousKeys();
            }

            if ($config['permissive_casting']) {
                $builder = $builder->allowPermissiveTypes();
            }

            if (!empty($config['supported_date_formats'])) {
                $builder = $builder->supportDateFormats(...$config['supported_date_formats']);
            }

            return $builder
                ->infer(name: DateTimeInterface::class, callback: fn() => $config['datetime_object']);
        });

        $this->app->singleton(
            abstract: TreeMapper::class,
            concrete: fn (Application $app): TreeMapper => $app->make(MapperBuilder::class)
                ->mapper()
        );

        $this->app->alias(TreeMapper::class, 'valinor.mapper');
    }

    /**
     * @return array<string|class-string>
     */
    public function provides(): array
    {
        return [
            'valinor.mapper',
            MapperBuilder::class,
            TreeMapper::class,
        ];
    }
}
