<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Validation\Attributes;

use Attribute;
use HSkrasek\LaravelValinor\Validation\ValidatingAttribute;
use Illuminate\Validation\Rules\Dimensions as IlluminateDimensions;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Dimensions implements ValidatingAttribute
{
    public function __construct(
        public int $width,
        public int $height,
        public int $minWidth,
        public int $minHeight,
        public int $maxWidth,
        public int $maxHeight,
        public float $ratio,
    ) {}

    public function toRule(): IlluminateDimensions
    {
        return new IlluminateDimensions(get_object_vars($this));
    }

    public function __toString(): string
    {
        return (string) $this->toRule();
    }
}
