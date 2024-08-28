<?php

declare(strict_types=1);

namespace HSkrasek\LaravelValinor\Http;

use Illuminate\Container\Container;
use Illuminate\Routing\Redirector;

class ParsedRequest {
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
}
