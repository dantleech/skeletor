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

class Closet
{
    private $pathInfo;
    private $filesystem;

    public function __construct(
        PathInformation $pathInfo,
        Filesystem $filesystem = null
    ) {
        $this->pathInfo = $pathInfo;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function hasSkeleton($org, $repo)
    {
        $repoDir = $this->pathInfo->getSkeletonDir($org, $repo);

        return $this->filesystem->exists($repoDir);
    }

    public function getSkeletonDir($org, $repo)
    {
        if (false === $this->hasSkeleton($org, $repo)) {
            throw new \InvalidArgumentException(sprintf(
                'Skeleton "%s/%s" has not been installed. Skeletor is not happy. Rawwwww',
                $org, $repo
            ));
        }

        $repoDir = $this->pathInfo->getSkeletonDir($org, $repo);

        return $repoDir;
    }

    public function getSkeletons()
    {
        $skeletons = [];
        $dataDir = $this->pathInfo->getDataDir();
        foreach ($this->filesystem->ls($dataDir) as $org) {
            if ($org->isDot() || !$org->isDir()) {
                continue;
            }

            foreach ($this->filesystem->ls($dataDir . DIRECTORY_SEPARATOR . $org->getFilename()) as $repo) {
                if ($repo->isDot() || !$repo->isDir()) {
                    continue;
                }

                $skeletons[] = $org->getFilename() . '/' . $repo->getFilename();
            }
        }

        return $skeletons;
    }
}
