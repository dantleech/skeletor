<?php

namespace Skeletor;

interface HostingInterface
{
    public function getRepositoryUrl($org, $repo);
    public function getRawUrl($org, $repo);
}
