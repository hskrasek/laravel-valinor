<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Validation;

use Stringable;

interface ValidatingAttribute extends Stringable
{
    public function toRule(): mixed;
}
