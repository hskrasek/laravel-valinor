<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Tests\Fixtures;

use DateTimeInterface;

final readonly class Thread
{
    public function __construct(
        public int $id,
        public string $content,
        public DateTimeInterface $date,
        /** @var Answer[] */
        public array $answers,
    ) {}
}
