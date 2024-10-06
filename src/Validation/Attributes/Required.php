<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Validation\Attributes;

use Attribute;
use HSkrasek\LaravelValinor\Validation\ValidatingAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required implements ValidatingAttribute
{
    public function __toString(): string
    {
        return $this->toRule();
    }

    public function toRule(): string
    {
        return 'required';
    }
}
