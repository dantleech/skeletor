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

use Symfony\Component\Debug\Debug;

class Skeletor
{
    const VERSION = '@package_version@';
    const CONFIG_NAME = 'skeletor';

    public static function run()
    {
        Debug::enable(true);
        $container = new Container();
        $container['application']->run();
    }

    public static function title()
    {
        return <<<'EOT'
<red>
    _____ __ __ ________    ________________  ____ 
   / ___// //_// ____/ /   / ____/_  __/ __ \/ __ \
   \__ \/ ,<  / __/ / /   / __/   / / / / / / /_/ /
  ___/ / /| |/ /___/ /___/ /___  / / / /_/ / _, _/ 
 /____/_/ |_/_____/_____/_____/ /_/  \____/_/ |_|  
</>
EOT;
    }

    public static function plainSkeletor()
    {
        $skeletor = <<<'EOT'
                            . .                  
                    ..~:+++:~~..                  
               .  .:+=ooo===o==+:~.               
                ~+=o===+===========~~ .           
              ~+o==============+===o=+.           
         . ..~:++ooo=+=========o==:~~~:~..        
       . .:=oo+~~~:+===========:~~~:==ooo=~ .     
     .. ~==~~~+o=+:~+======+===::=oo=~~..:o: .    
    .. .o+.     ~+=ooo=::=+=~+=oo=:~      ~o~ ..  
   ... ~o~        .~~~~~~  ~::~..          ==  .  
  .... ~o:          .~+. ~~  :+~          ~o=. ...
  ...  :o: .~~~~~~~:=o:.~=o:~~=o++::~~~~~.~+o~ ...
....  :=+~+=o==oo======o==========~+ooo=o=+:==. . 
.... :===o====o+~~:=========o=====:~~+========+  .
 .. ~o=======+~~:=oo++~~~~:~::==o===:.~=======o: .
... ~=======~.:oo=~~+~~o:.o+.+.~+=====. :======: .
... ~o====:..=o:~~:~o=~+:.:~~=~=~~~==o:  .+====~ .
..   +===~   :::+~o...        .+:o::=~     ~o=:   
 .   .+=.      ~:                ~~     ~~  ~~    
.        .:~        ~~~:.~:~~.         .oo+~      
.      ~:=o:    ..+:~o:=~~=:=~+:~.     +====.     
.     .oo==:    +::~~:::+++:+::~+:    .=====.     
      .=+=o:   ~:+:===o====o====+~~   :==+=:      
       =====:::oo=o========+====ooo+:+====o~      
       +===================o===============.      
      .=========+==o==+++::++==============.      
      .o========o=+~..        .~:==o=======~      
       :=o=====+:~               .~:=======~      
       .~+++~~                     .~:::~        

EOT;

        return $skeletor;
    }

    public static function skeletor()
    {
        $skeletor = self::plainSkeletor();
        $skeletor = preg_replace('{([\~\:o=\+]+)}', '<bone>\1</>', $skeletor);
        $skeletor = preg_replace('{(\.+)}', '<skeletor>\1</>', $skeletor);

        return $skeletor;
    }

    public static function rainbowSkeletor($frame = 0)
    {
        $skeletor = explode(PHP_EOL, self::plainSkeletor());
        $delta = 1;
        $lines = [];

        foreach ($skeletor as $index => $line) {
            // start at 32 to avoid the ugly colors
            $color = 32 + ((floor($frame * $delta) + $index) % 223);
            $lines[] = "\x1B[38;5;" . $color . 'm' . $line;
        }

        return implode(PHP_EOL, $lines);
    }

    public static function animatedSkeletor($output)
    {
        $count = 0;
        $first = true;

        // hide the cursor
        echo "\x1B[?25l";
        while (true) {
            usleep(50000);
            $output->write($title = self::title());
            $output->write($skeletor = self::rainbowSkeletor($count));
            if ($first) {
                $output->write($say = self::say());
            }
            $output->write(str_repeat("\n", 10));
            $output->write("\x1B[" . (substr_count($skeletor . $title . $say, "\n") + 10) . 'A');
            $count++;
            $first = false;
        }
    }

    public static function parseRepo($repo)
    {
        preg_match('{(.*)/(.*)}', $repo, $matches);

        if (count($matches) != 3) {
            throw new \InvalidArgumentException(sprintf(
                'Could not parse repo "%s". Should be of the form "org/repo" (e.g. dantleech/skeletor.skeletor)',
                $repo
            ));
        }

        return [$matches[1], $matches[2]];
    }

    public static function say($character = 'skeletor')
    {
        $quotes = file_get_contents(__DIR__ . '/quotes.txt');
        $quotes = explode(PHP_EOL, $quotes);
        $has = 0;

        do {
            $has++;
            $quote = trim($quotes[rand(0, count($quotes))]);
            preg_match('{^(.*?): (.*)$}', $quote, $matches);
        } while (null !== $character && strtolower($matches[1]) !== trim(strtolower($character)));

        $matches[2] .= str_repeat('!', $has);

        return implode(
            PHP_EOL,
            [
                sprintf('"<say>%s</>"', $matches[2]),
                sprintf(' %46s', ' - ' . $matches[1]),
            ]
        );
    }

    public static function skeletorHeader()
    {
        return '  ' . implode(
            PHP_EOL . '  ',
            [
                self::title(),
                self::skeletor(),
                wordwrap(self::say(), 45, "\n  "),
            ]
        ) . PHP_EOL;
    }
}
