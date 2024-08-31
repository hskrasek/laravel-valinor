<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Config;

use ArrayAccess;

class Configuration implements ArrayAccess
{
    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }

    /**
     * @return array<non-empty-string, class-string>
     */
    public static function mapping(): array
    {
        return [];
    }
}
