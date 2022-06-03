<?php

namespace Dudoserovich\ModifyChat;

class ServiceLocator
{
    private $services;

    public function has(string $serviceName): bool {
        return isset($this->services[$serviceName]);
    }

    public function set(string $serviceName, $service) {
        $this->services[$serviceName] = $service;
    }

    public function get(string $serviceName) {
        if (is_callable($this->services[$serviceName]))
            $this->services[$serviceName] = $this->services[$serviceName]($this);

        return $this->services[$serviceName];
    }
}