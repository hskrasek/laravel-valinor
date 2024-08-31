<?php

declare(strict_types=1);

use HSkrasek\LaravelValinor\Config\Configuration\App;
use HSkrasek\LaravelValinor\Config\Repository;
use HSkrasek\LaravelValinor\Tests\Fixtures\TestConfiguration;

describe('Config Repository', function () {
    it('gets value when key contains a dot', function () {
        $repository = new Repository(
            new TestConfiguration,
            [
                'app' => [
                    'name' => 'Laravel',
                    'env' => 'production',
                    'debug' => false,
                    'url' => 'http://localhost',
                    'timezone' => 'UTC',
                    'locale' => 'en',
                    'fallback_locale' => 'en',
                    'faker_locale' => 'en_US',
                    'cipher' => 'AES-256-CBC',
                    'key' => '',
                    'previous_keys' => [
                        ...array_filter(
                            explode(',', '')
                        ),
                    ],
                    'maintenance' => [
                        'driver' => 'file',
                        'store' => 'database',
                    ],
                ],
            ]
        );

        /** @var App $config */
        expect($config = $repository->get('app'))
            ->toBeInstanceOf(App::class)
            ->and($config->name)
            ->toBe('Laravel')
            ->and($repository->get('app.name'))
            ->toBe('Laravel');
    });

    it('has a value', function () {
        $repository = new Repository(
            new TestConfiguration,
            [
                'app' => [
                    'name' => 'Laravel',
                    'env' => 'production',
                    'debug' => false,
                    'url' => 'http://localhost',
                    'timezone' => 'UTC',
                    'locale' => 'en',
                    'fallback_locale' => 'en',
                    'faker_locale' => 'en_US',
                    'cipher' => 'AES-256-CBC',
                    'key' => '',
                    'previous_keys' => [
                        ...array_filter(
                            explode(',', '')
                        ),
                    ],
                    'maintenance' => [
                        'driver' => 'file',
                        'store' => 'database',
                    ],
                ],
            ]
        );

        expect($repository->has('app'))
            ->toBeTrue()
            ->and($repository->has('app.name'))
            ->toBeTrue();
    });

    it('returns many when passed an array of keys', function () {
        $repository = new Repository(
            new TestConfiguration,
            [
                'app' => [
                    'name' => 'Laravel',
                    'env' => 'production',
                    'debug' => false,
                    'url' => 'http://localhost',
                    'timezone' => 'UTC',
                    'locale' => 'en',
                    'fallback_locale' => 'en',
                    'faker_locale' => 'en_US',
                    'cipher' => 'AES-256-CBC',
                    'key' => '',
                    'previous_keys' => [
                        ...array_filter(
                            explode(',', '')
                        ),
                    ],
                    'maintenance' => [
                        'driver' => 'file',
                        'store' => 'database',
                    ],
                ],
            ]
        );

        expect($repository->get(['app.name', 'app.env']))
            ->toBeArray()
            ->toMatchArray(['app.name' => 'Laravel', 'app.env' => 'production'])
            ->and($repository->get(['app']))
            ->toBeArray()
            ->toHaveKey('app');
    });

    it('returns the default value when key does not exist', function () {
        $repository = new Repository(new TestConfiguration, []);

        expect($repository->get('missingno', 'default'))
            ->toEqual('default');
    });

    it('sets configuration values', function () {
        $repository = new Repository(
            new TestConfiguration,
            [
                'app' => [
                    'name' => 'Laravel',
                    'env' => 'production',
                    'debug' => false,
                    'url' => 'http://localhost',
                    'timezone' => 'UTC',
                    'locale' => 'en',
                    'fallback_locale' => 'en',
                    'faker_locale' => 'en_US',
                    'cipher' => 'AES-256-CBC',
                    'key' => '',
                    'previous_keys' => [
                        ...array_filter(
                            explode(',', '')
                        ),
                    ],
                    'maintenance' => [
                        'driver' => 'file',
                        'store' => 'database',
                    ],
                ],
            ]
        );

        $repository->set('foo', 'bar');

        expect($repository->get('foo'))
            ->toBe('bar');

        $repository->set('app.name', 'Valinor');

        expect($repository->get('app.name'))
            ->toBe('Valinor');
    });
});
