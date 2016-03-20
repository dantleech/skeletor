<?php

namespace Skeletor;

use Skeletor\NodeContext;

interface HandlerInterface
{
    public function process(NodeContext $context);
}
