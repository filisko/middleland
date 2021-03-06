<?php

namespace Middleland\Tests;

use Psr\Container\ContainerInterface;

class FakeContainer implements ContainerInterface
{
    public function has($id)
    {
        return true;
    }

    public function get($id)
    {
        return new FakeMiddleware($id);
    }
}
