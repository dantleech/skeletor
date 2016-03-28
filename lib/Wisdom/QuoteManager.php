<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Wisdom;

use Skeletor\Util\Filesystem;
use Skeletor\Wisdom\Character\Skeletor;
use Symfony\Component\Console\Output\OutputInterface;

class QuoteManager
{
    private $character;
    private $filesystem;

    public function __construct(CharacterInterface $character = null, Filesystem $filesystem = null)
    {
        $this->character = $character ?: new Skeletor();
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    public function rainbow($frame = 0)
    {
        $skeletor = explode(PHP_EOL, $this->character->face());
        $delta = 1;
        $lines = [];

        foreach ($skeletor as $index => $line) {
            // start at 32 to avoid the ugly colors
            $color = 32 + ((floor($frame * $delta) + $index) % 223);
            $lines[] = "\x1B[38;5;" . $color . 'm' . $line;
        }

        return implode(PHP_EOL, $lines);
    }

    public function say()
    {
        $quotes = $this->filesystem->get($this->character->quotes());
        $quotes = explode(PHP_EOL, $quotes);
        $quote = trim($quotes[rand(0, count($quotes))]);

        return implode(
            PHP_EOL,
            [
                sprintf('"<say>%s</>"', $quote),
                sprintf(' %46s', ' - ' . $this->character->attribution()),
            ]
        );
    }

    public function animate(OutputInterface $output)
    {
        $frame = 0;
        $rate = 50000;
        $largestQuote = 0;
        $quoteChange = 100;
        $quote = null;

        // hide the cursor
        //$output->write("\x1B[?25l");
        while (true) {
            $out = [];
            usleep($rate);
            $out[] = $this->rainbow($frame);

            if (null === $quote || 0 === $frame % $quoteChange) {
                $quote = $this->say();
            }

            $say = "\n\n\x1B[0J  " . wordwrap($quote, 45, "\n  ");
            $out[] = $say;

            $quoteCount = substr_count($say, PHP_EOL);
            if ($quoteCount > $largestQuote) {
                $largestQuote = $quoteCount;
            }

            if ($quoteCount < $largestQuote) {
                $out[] = str_repeat(PHP_EOL . "\x1B[0J", $largestQuote - $quoteCount);
            }

            $out[] = PHP_EOL;
            $rawOut = implode(PHP_EOL, $out);
            // move cursor back up
            $offset = (substr_count($rawOut, PHP_EOL));
            $output->write($rawOut);
            $output->write("\x1B[" . $offset . 'A');
            $frame++;
        }
    }

    public function quote(OutputInterface $output)
    {
        $output->write('  ' . implode(
            PHP_EOL . '  ',
            [
                $this->character->face(true),
                wordwrap($this->say(), 45, "\n  "),
            ]
        ) . PHP_EOL);
    }
}
