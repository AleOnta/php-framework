<?php

namespace App\Core;

class Container
{
    private array $services = [];

    # store dependencies in the container
    public function set(string $key, callable $resolver)
    {
        $this->services[$key] = $resolver;
    }

    # return the requested dependencies if availables
    public function get($key)
    {
        if (!isset($this->services[$key])) {
            throw new \Exception("Service '{$key}' not found.");
        }
        return $this->services[$key]($this);
    }
}
