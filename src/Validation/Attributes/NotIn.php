<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Validation\Attributes;

use Attribute;
use HSkrasek\LaravelValinor\Validation\ValidatingAttribute;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\NotIn as IlluminateNotIn;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotIn implements ValidatingAttribute
{
    protected array $values;

    public function __construct($value, ...$values)
    {
        if ($value instanceof Arrayable) {
            $values = $value->toArray();
        }

        $this->values = is_array($value) ? $value : $values;
    }

    public function __toString()
    {
        return (string) $this->toRule();

    }

    public function toRule(): IlluminateNotIn
    {
        return Rule::notIn($this->values);
    }
}
