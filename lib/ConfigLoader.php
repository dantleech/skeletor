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

use JsonSchema\Uri\UriRetriever;
use JsonSchema\Validator;
use Seld\JsonLint\JsonParser;

class ConfigLoader
{
    private $jsonParser;
    private $validator;
    private $uriRetriever;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?: new Filesystem();
        $this->jsonParser = new JsonParser();
        $this->validator = new Validator();
        $this->uriRetriever = new UriRetriever();
    }

    public function load($repoDir)
    {
        $configPath = $repoDir . DIRECTORY_SEPARATOR . Skeletor::CONFIG_NAME . '.json';

        if (false === $this->filesystem->exists($configPath)) {
            throw new \InvalidArgumentException(sprintf(
                'Skeletor config "%s.json" does not exist in skeleton closet at "%s"',
                Skeletor::CONFIG_NAME,
                $repoDir
            ));
        }

        $configRaw = $this->filesystem->get($configPath);

        $error = $this->jsonParser->lint($configRaw);

        if ($error) {
            throw $error;
        }

        // validate the configuration against the JSON schema.  the validator
        // only accepts an object, however we want an array, for this reason we
        // reencode and then decode to an array after validation.
        $config = json_decode($configRaw);
        $this->validate($config);
        $config = json_decode(json_encode($config), true);

        $config = $this->buildConfig($config, [
            'title' => null,
            'description' => null,
            'params' => [],
            'basedir' => 'skeletor',
            'files' => [],
        ]);

        // use "template" as the default type - assuming that this
        // will be the most common use case.
        foreach ($config['files'] as $index => $file) {
            $config['files'][$index] = $this->buildConfig($file, [
                'type' => 'template',
            ]);
        }

        return $config;
    }

    private function buildConfig(array $config, array $defaults)
    {
        $config = array_merge(
            $defaults,
            $config
        );

        return $config;
    }

    private function validate(\stdClass $config)
    {
        $schema = $this->uriRetriever->retrieve('file://' . __DIR__ . '/schema.json');
        $this->validator->check($config, $schema);
        $errors = $this->validator->getErrors();

        if ($errors) {
            $errorString = [];
            foreach ($errors as $error) {
                $errorString[] = sprintf(
                    '[%s] %s',
                    $error['property'],
                    $error['message']
                );
            }

            throw new \InvalidArgumentException(sprintf(
                "Invalid configuration: \n  %s",
                implode("\n  ", $errorString)
            ));
        }
    }
}
