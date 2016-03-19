<?php

namespace Skeletor;

use Symfony\Component\Console\Output\OutputInterface;
use Skeletor\Filesystem;

class Generator
{
    private $pathInfo;
    private $filesystem;
    private $configLoader;
    private $processorRegistry;

    public function __construct(
        PathInformation $pathInfo, 
        ConfigLoader $configLoader, 
        ProcessorRegistry $processorRegistry,
        Filesystem $filesystem = null
    )
    {
        $this->pathInfo = $pathInfo;
        $this->configLoader = $configLoader;
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->processorRegistry = $processorRegistry;
    }

    public function generate(OutputInterface $output, $org, $repo, $dstRootPath)
    {
        $repoDir = $this->pathInfo->getRepoDir($org, $repo);

        if (false === $this->filesystem->exists($repoDir)) {
            $output->writeln(Skeletor::skeletor());
            throw new \InvalidArgumentException(sprintf(
                "Skeleton \"%s\" has not been installed. Skeletor is not happy. Rawwwww",
                $repoDir
            ));
        }

        $config = $this->configLoader->load($repoDir);

        $srcRootPath = $repoDir . DIRECTORY_SEPARATOR . $config['basedir'];

        if (false === $this->filesystem->exists($srcRootPath)) {
            throw new \RuntimeException(sprintf(
                'Basedir "%s" does not exist for skeleton closet "%s"',
                $srcRootPath, $repoDir
            ));
        }

        $output->writeln(sprintf('<comment>Skeletating </>%s<comment> in </>%s<comment>:</>', $repo, $dstRootPath));
        $output->write(PHP_EOL);

        foreach ($config['files'] as $nodePath => $nodeConfig) {

            // the key is assumed to be the destination filename unless
            // explicitly defined.
            if (isset($nodeConfig['path'])) {
                $nodePath = $nodeConfig['path'];
            }

            $context = new NodeContext(
                $srcRootPath,
                $dstRootPath,
                $nodePath,
                $nodeConfig,
                $config['params']
            );

            $output->writeln(sprintf(' + [%s] %s', $nodeConfig['type'], $context->getAbsDstPath()));
            $processor = $this->processorRegistry->get($nodeConfig['type']);
            $processor->process($context);
        }
    }
}
