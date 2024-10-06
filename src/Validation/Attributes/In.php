<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Validation\Attributes;

use Attribute;
use HSkrasek\LaravelValinor\Validation\ValidatingAttribute;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In as IlluminateIn;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class In implements ValidatingAttribute
{
    protected array $values;

    public function __construct($value, ...$values)
    {
        if ($value instanceof Arrayable) {
            $values = $value->toArray();
        }

        $this->values = is_array($value) ? $value : $values;
    }

    public function __toString(): string
    {
        return (string) $this->toRule();
    }

    public function toRule(): IlluminateIn
    {
        return Rule::in($this->values);
    }
}
