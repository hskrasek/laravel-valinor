<?php

declare(strict_types=1);

use CuyZ\Valinor\Mapper\TreeMapper;

describe('mapper', function () {
    it('supports flexible casting', function () {
        config()->set('valinor.flexible_casting', true);

        /** @var TreeMapper $mapper */
        $mapper = resolve(TreeMapper::class);

        expect($mapper->map('int', '42'))
            ->toBeInt()
            ->toBe(42);
    });

    it('supports superfluous casting', function () {
        config()->set('valinor.superfluous_casting', true);

        /** @var TreeMapper $mapper */
        $mapper = resolve(TreeMapper::class);

        expect($mapper->map(
            signature: 'array{foo: string, bar: int}',
            source: [
                'foo' => 'bar',
                'bar' => 42,
                'baz' => false,
            ],
        ))->toBeArray()->toBe(['foo' => 'bar', 'bar' => 42]);
    });

    it('supports permissive casting', function () {
        config()->set('valinor.permissive_casting', true);

        /** @var TreeMapper $mapper */
        $mapper = resolve(TreeMapper::class);

        expect($mapper->map(
            signature: 'array{foo: string, bar: mixed}',
            source: [
                'foo' => 'baz',
                'bar' => 42,
            ],
        ))->toBeArray()->toBe(['foo' => 'baz', 'bar' => 42]);
    });
});
