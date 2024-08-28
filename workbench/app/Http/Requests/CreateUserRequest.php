<?php

declare(strict_types=1);

namespace Workbench\App\Http\Requests;

use HSkrasek\LaravelValinor\Http\ParsedRequest;

class CreateUserRequest extends ParsedRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        #[\SensitiveParameter]
        public readonly string $password,
    ) {}
}
