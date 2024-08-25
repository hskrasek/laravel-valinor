<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Tests\Fixtures;

use DateTimeInterface;

final readonly class Answer
{
    public function __construct(
        public string $user,
        public string $message,
        public DateTimeInterface $date,
    ) {}
}
