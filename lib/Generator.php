<?php

namespace Skeletor;

use Symfony\Component\Console\Output\OutputInterface;
use Skeletor\Filesystem;

class Generator
{
    private $pathInfo;
    private $filesystem;

    public function __construct(PathInformation $pathInfo, Filesystem $filesystem = null)
    {
        $this->pathInfo = $pathInfo;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function generate(OutputInterface $output, $org, $repo, $targetPath)
    {
        $repoDir = $this->pathInfo->getRepoDir($org, $repo);

        if (false === $this->filesystem->exists($repoDir)) {
            $output->writeln(Skeletor::skeletor());
            throw new \InvalidArgumentException(sprintf(
                "Skeleton \"%s\" has not been installed. Skeletor is not happy. Rawwwww",
                $repoDir
            ));
        }

        $config = $this->configLoader->loadConfig($repoDir);

        $baseDir = $repoDir . DIRECTORY_SEPARATOR . $config['basedir'];

        if (false === $this->filesystem->exists($baseDir)) {
            throw new \RuntimeException(sprintf(
                'Basedir "%s" does not exist for skeleton closet "%s"',
                $baseDir, $repoDir
            ));
        }

        $output->writeln(sprintf('<comment>Skeletating </>%s<comment> in </>%s<comment>:</>', $repo, $targetPath));
        $output->write(PHP_EOL);
        $this->skeletate($output, $baseDir, $targetPath, $config['nodes'], $config['params'], $targetPath);
    }

    private function skeletate(OutputInterface $output, $currentPath, $targetPath, array $nodes, array $params)
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

            $output->writeln(sprintf('  <info>[</><comment>+</><info>]</> <comment>%s</> %s', $node['type'] == 'dir' ? 'd' : 'f', $tPath));

            if ($node['type'] == 'dir') {
                $this->filesystem->mkdir($tPath);
                $this->skeletate(
                    $output,
                    $currentPath . DIRECTORY_SEPARATOR . $name,
                    $targetPath . DIRECTORY_SEPARATOR . $name,
                    $node['nodes'],
                    $params
                );
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

        // TODO: Check for existence of target, only overwrite if force=true

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
