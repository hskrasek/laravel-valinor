<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor;

use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
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
        $this->app->singleton(MapperBuilder::class, function (Application $app): MapperBuilder {
            $builder = new MapperBuilder;

            if (config('valinor.flexible_casting')) {
                $builder = $builder->enableFlexibleCasting();
            }

            if (config('valinor.superfluous_casting')) {
                $builder = $builder->allowSuperfluousKeys();
            }

            if (config('valinor.permissive_casting')) {
                $builder = $builder->allowPermissiveTypes();
            }

            return $builder;
        });

        $this->app->singleton(
            abstract: TreeMapper::class,
            concrete: fn (Application $app): TreeMapper => $app->make(MapperBuilder::class)
                ->mapper()
        );
    }
}
