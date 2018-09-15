<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Installer\Hosting;

use Skeletor\Installer\HostingInterface;

class GithubHosting implements HostingInterface
{
    public function getRepositoryUrl($org, $repo)
    {
        return sprintf(
            'https://github.com/%s/%s',
            $org,
            $repo
        );
    }

    public function getPublicUrl($org, $repo)
    {
        return sprintf(
            'https://github.com/%s/%s',
            $org,
            $repo
        );
    }

    public function getRawUrl($org, $repo)
    {
        return sprintf('https://raw.githubusercontent.com/%s/%s/master', $org, $repo);
    }
}
