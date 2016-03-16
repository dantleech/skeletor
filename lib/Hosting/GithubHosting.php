<?php

namespace Skeletor\Hosting;

use Skeletor\HostingInterface;
use Skeletor\Skeletor;

class GithubHosting implements HostingInterface
{
    public function getRepositoryUrl($org, $repo)
    {
        return sprintf(
            'git@github.com:%s/%s',
            $org, $repo
        );
    }

    public function getRawUrl($org, $repo)
    {
        return sprintf('https://raw.githubusercontent.com/%s/%s/master', $org, $repo);
    }
}
