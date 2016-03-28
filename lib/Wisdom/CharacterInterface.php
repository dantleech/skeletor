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

interface CharacterInterface
{
    /**
     * Return the ascii representation of the characters face.
     */
    public function face($colourize = false);

    /**
     * Return the path to a text file containing quotes by this charcter.
     */
    public function quotes();

    /**
     * Return the attribution for the quotes (i.e. the characters name).
     */
    public function attribution();
}
