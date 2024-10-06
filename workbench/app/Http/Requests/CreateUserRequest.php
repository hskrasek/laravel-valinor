<?php

declare(strict_types=1);

namespace Workbench\App\Http\Requests;

use HSkrasek\LaravelValinor\Http\ParsedRequest;
use HSkrasek\LaravelValinor\Validation\Attributes\Required;

class CreateUserRequest extends ParsedRequest
{
    public function __construct(
        #[Required]
        public readonly string $name,
        #[Required]
        public readonly string $email,
        #[\SensitiveParameter]
        public readonly string $password,
    ) {}
}
