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

use Symfony\Component\Console\Output\OutputInterface;

class Generator
{
    private $filesystem;
    private $handlerRegistry;

    public function __construct(
        HandlerRegistry $handlerRegistry,
        Filesystem $filesystem = null
    ) {
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->handlerRegistry = $handlerRegistry;
    }

    public function generate(OutputInterface $output, $config, $dstRootPath, array $params = [])
    {
        $srcRootPath = $config['repo_dir'] . DIRECTORY_SEPARATOR . $config['basedir'];

        if (false === $this->filesystem->exists($srcRootPath)) {
            throw new Exception\InvalidSkeletorException(sprintf(
                'Basedir "%s" does not exist for skeletor "%s"',
                $srcRootPath, $config['repo_dir']
            ));
        }

        $output->writeln(sprintf('<info>Generating </>%s<info> skeletor in </>%s<info>:</>', basename($config['repo_dir']), $dstRootPath));
        $output->write(PHP_EOL);

        foreach ($config['files'] as $nodePath => $nodeConfig) {

            // the key is assumed to be the destination filename unless
            // explicitly defined.
            //
            // TODO: Can this be done in the ConifgLoader?
            if (isset($nodeConfig['path'])) {
                $nodePath = $nodeConfig['path'];
            }

            $context = new NodeContext(
                $srcRootPath,
                $dstRootPath,
                $nodePath,
                $nodeConfig,
                $params
            );

            $output->writeln(sprintf(" [+] <comment>%'.-12s</> ./%s", $nodeConfig['type'], $context->getAbsDstPath()));
            $handler = $this->handlerRegistry->get($nodeConfig['type']);
            $handler->process($context);
        }
    }
}
