<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor;

interface HostingInterface
{
    public function getRepositoryUrl($org, $repo);

    public function getRawUrl($org, $repo);
}
