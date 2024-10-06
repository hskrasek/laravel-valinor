<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Http;

use HSkrasek\LaravelValinor\Validation\ValidatingAttribute;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidatesWhenResolvedTrait;

class ParsedRequest implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    protected Container $container;

    protected Redirector $redirector;

    public function withContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function withRedirector(Redirector $redirector): self
    {
        $this->redirector = $redirector;

        return $this;
    }

    /**
     * @todo Take this further
     */
    public function parsedRules(): array
    {
        $instance = new \ReflectionClass($this);
        $properties = $instance->getProperties();

        $rules = [];

        foreach ($properties as $property) {
            $rules[] = $property->getAttributes(ValidatingAttribute::class, \ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;
        }

        return array_map(function (\ReflectionAttribute $attribute) {
            /** @var ValidatingAttribute $instance */
            $instance = $attribute->newInstance();

            return $instance->toRule();
        }, array_filter($rules));
    }
}
