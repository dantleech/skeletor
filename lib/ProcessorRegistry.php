<?php

namespace Skeletor;

class ProcessorRegistry
{
    private $processors = [];

    public function __construct(array $processors = [])
    {
        $this->processors = $processors;
    }

    public function get($name)
    {
        if (!isset($this->processors[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'No processor exists with name "%s", valid processors: "%s"',
                $name, implode('", "', array_keys($this->processors))
            ));
        }

        return $this->processors[$name];
    }
}
