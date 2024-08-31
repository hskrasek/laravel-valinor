<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Config;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use Illuminate\Contracts\Config\Repository as ConfigContract;

class Repository implements \ArrayAccess, ConfigContract
{
    /**
     * @var array<non-empty-string, class-string<Configuration>>
     */
    protected array $items;

    public function __construct(
        protected readonly Configuration $configuration,
        array $items = [],
    ) {
        $this->items = $items;

        foreach ($items as $name => $value) {
            $value = Source::array($value)
                ->camelCaseKeys();

            $this->items[$name] = (new MapperBuilder)
                ->mapper()
                ->map(
                    signature: $this->configuration::mapping()[$name],
                    source: $value
                );
        }
    }

    public function has($key): bool
    {
        return (bool) data_get($this->items, $key);
    }

    public function get($key, $default = null): float|int|bool|array|string|Configuration
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return data_get($this->items, $key, $default);
    }

    public function getMany(array $keys): array
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }

            $config[$key] = data_get($this->items, $key, $default);
        }

        return $config;
    }

    /**
     * @return class-string[]
     */
    public function all(): array
    {
        return $this->items;
    }

    public function set($key, $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            data_set($this->items, $key, $value);
        }
    }

    public function prepend($key, $value): void
    {
        $items = $this->get($key, []);

        array_unshift($items, $value);

        $this->set($key, $items);
    }

    public function push($key, $value): void
    {
        $items = $this->get($key, []);

        $items[] = $value;

        $this->set($key, $items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->set($offset, null);
    }
}
