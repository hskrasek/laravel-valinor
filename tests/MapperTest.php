<?php

declare(strict_types=1);

use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\Mapper\TreeMapper;
use HSkrasek\LaravelValinor\Facades\Mapper;
use HSkrasek\LaravelValinor\Tests\Fixtures\Answer;

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

        expect(
            $mapper->map(
                signature: 'array{foo: string, bar: int}',
                source: [
                    'foo' => 'bar',
                    'bar' => 42,
                    'baz' => false,
                ],
            )
        )->toBeArray()->toBe(['foo' => 'bar', 'bar' => 42]);
    });

    it('supports permissive casting', function () {
        config()->set('valinor.permissive_casting', true);

        /** @var TreeMapper $mapper */
        $mapper = resolve(TreeMapper::class);

        expect(
            $mapper->map(
                signature: 'array{foo: string, bar: mixed}',
                source: [
                    'foo' => 'baz',
                    'bar' => 42,
                ],
            )
        )->toBeArray()->toBe(['foo' => 'baz', 'bar' => 42]);
    });

    it('maps sources via the facade', function () {
        $thread = Mapper::map(
            signature: \HSkrasek\LaravelValinor\Tests\Fixtures\Thread::class,
            source: new JsonSource(
                <<<'JSON'
                {
                    "id": 1337,
                    "content": "Do you like potatoes?",
                    "date": "1957-07-23 13:37:42",
                    "answers": [
                        {
                            "user": "Ella F.",
                            "message": "I like potatoes",
                            "date": "1957-07-31 15:28:12"
                        },
                        {
                            "user": "Louis A.",
                            "message": "And I like tomatoes",
                            "date": "1957-08-13 09:05:24"
                        }
                    ]
                }
                JSON
            )
        );

        expect($thread)
            ->toBeInstanceOf(\HSkrasek\LaravelValinor\Tests\Fixtures\Thread::class)
            ->and($thread->id)
            ->toBe(1337)
            ->and($thread->answers)
            ->toBeArray()
            ->not
            ->toBeEmpty()
            ->and($thread->answers[0])
            ->toBeInstanceOf(Answer::class);
    });
});
