<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Validation\Attributes;

use Attribute;
use HSkrasek\LaravelValinor\Validation\ValidatingAttribute;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Validation\Rules\DatabaseRule;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Exists implements ValidatingAttribute
{
    use Conditionable;
    use DatabaseRule;

    public function __toString()
    {
        return $this->toRule();
    }

    public function toRule(): string
    {
        return rtrim(sprintf('exists:%s,%s,%s',
            $this->table,
            $this->column,
            $this->formatWheres()
        ), ',');
    }
}
