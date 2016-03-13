<?php

namespace Skeletor;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Generator
{
    private $config;

    public function __construct(Configuration $config, Filesystem $filesystem = null)
    {
        $this->config = $config;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function generate(OutputInterface $output, $org, $repo, $targetPath)
    {
        $repoDir = $this->config->getRepoDir($org, $repo);

        if (false === $this->filesystem->exists($repoDir)) {
            $output->writeln(Skeletor::skeletor());
            throw new \InvalidArgumentException(sprintf(
                "Skeleton \"%s\" has not been installed. Skeletor is not happy. Rawwwww",
                $repoDir
            ));
        }

        $configPath = $repoDir . DIRECTORY_SEPARATOR . 'skeletor.json';

        if (false === $this->filesystem->exists($configPath)) {
            throw new \InvalidArgumentException(sprintf(
                'Skeletor config "skeleton.json" does not exist in skeleton closet at "%s"',
                $repoDir
            ));
        }

        // TODO: Use JsonParser
        $config = json_decode(file_get_contents($configPath), true);

        if (false === $config) {
            throw new \InvalidArgumentException(sprintf(
                'Could not decode SKLAESON file at "%s"',
                $configPath
            ));
        }

        $config = array_merge([
            'basedir' => 'skeletor',
            'params' => [],
            'nodes' => [],
        ], $config);

        $baseDir = $repoDir . DIRECTORY_SEPARATOR . $config['basedir'];

        if (false === $this->filesystem->exists($baseDir)) {
            throw new \RuntimeException(sprintf(
                'Basedir "%s" does not exist for skeleton closet "%s"',
                $baseDir, $repoDir
            ));
        }

        $this->skeletate($baseDir, $targetPath, $config['nodes'], $config['params'], $targetPath);
    }

    private function skeletate($currentPath, $targetPath, array $nodes, array $params)
    {
        $nodeDefaults = [
            'type' => 'file',
            'nodes' => [],
        ];
        foreach ($nodes as $name => $node) {
            if ($diff = array_diff(array_keys($node), array_keys($nodeDefaults))) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid node options: "%s", valid node options: "%s"',
                    implode('", "', $diff),
                    implode('", "', array_keys($nodeDefaults))
                ));
            }

            $node = array_merge($nodeDefaults, $node);

            $path = $currentPath . DIRECTORY_SEPARATOR . $name;
            $tPath = $targetPath . DIRECTORY_SEPARATOR . $name;

            if ($node['type'] == 'dir') {
                $this->filesystem->mkdir($tPath);
            } elseif ($node['type'] == 'file') {
                $this->installFile($path, $tPath, $params);
            } else {
                throw new \RuntimeException(sprintf(
                    'Invalid node type "%s", must be either "file" or "dir"',
                    $node['type']
                ));
            }
        }
    }

    private function installFile($sourcePath, $destPath, array $params)
    {
        if (!$this->filesystem->exists($sourcePath)) {
            throw new \InvalidArgumentException(sprintf(
                'Source file "%s" does not exist.',
                $sourcePath
            ));
        }

        $contents = file_get_contents($sourcePath);

        preg_match_all('{%\s*(.*?)\s*%}', $contents, $matches);
        $tokens = $matches[1];

        if ($diff = array_diff($tokens, array_keys($params))) {
            throw new \InvalidArgumentException(sprintf(
                'Missing tokens "%s" for skeleton "%s"',
                implode('", "', $diff), $sourcePath
            ));
        }

        foreach ($params as $tokenName => $tokenValue) {
            $contents = preg_replace('{%\s*' . $tokenName . '\s*%}', $tokenValue, $contents);
            $this->filesystem->dumpFile($destPath, $contents);
        }
    }
}
