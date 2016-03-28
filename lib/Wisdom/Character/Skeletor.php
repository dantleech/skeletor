<?php

/*
 * This file is part of the Glob package.
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Skeletor\Wisdom\Character;

class Skeletor
{
    /**
     * {@inheritdoc}
     */
    public function face($colourize = false)
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

        if (true === $colourize) {
            $skeletor = preg_replace('{([\~\:o=\+]+)}', '<bone>\1</>', $skeletor);
            $skeletor = preg_replace('{(\.+)}', '<skeletor>\1</>', $skeletor);
        }

        return $skeletor;
    }

    /**
     * {@inheritdoc}
     */
    public function quotes()
    {
        return __DIR__ . '/quotes/skeletor.txt';
    }

    /**
     * {@inheritdoc}
     */
    public function attribution()
    {
        return 'Skeletor';
    }
}
