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

use Skeletor\Console\Application;
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
<bone>
    _____ __ __ ________    ________________  ____ 
   / ___// //_// ____/ /   / ____/_  __/ __ \/ __ \
   \__ \/ ,<  / __/ / /   / __/   / / / / / / /_/ /
  ___/ / /| |/ /___/ /___/ /___  / / / /_/ / _, _/ 
 /____/_/ |_/_____/_____/_____/ /_/  \____/_/ |_|  
</>
EOT;
    }

    public static function skeletor()
    {
        return <<<'EOT'
<skeletor>
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

</>
EOT;
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

    public static function say()
    {
        $quotes = <<<'EOT'
Fool! You are no longer my equal! I am more than man! More than life! I... am... a... GOD! Now. You... will... KNELL! KNELL! 
YOU! You will no longer stand between me and my destiny! 
I ache to smash you out of existence! To drive your cursed face from my memories forever! 
YES! Let this be our final battle! 
Kneel before your master... 
... fool, you are no longer my equal, I am more than man, more than life... I am a GOD! 
He-Man lives and possesses that key! I must possess all, or I possess nothing! 
You are all aware of the penalty for failure. 
I am not in a giving vein this day. 
GET AWAY! 
[pushing her away towards them] Save your pity for yourself if you fail. Take them and whatever troops and resources you need. 
Then you should not have spoken. Leave immediately. When you find the key, send a sourcing signal. An attack force will join you or I will follow. 
NO! Mine. 
Someone is speaking to me... yes. Sorceress, my lovely prisoner, my prisoner at last. I've won. I've won. The darkness is rising to embrace you. 
Really? How sensitive you are. Can you feel - this? 
Not the way to treat your beloved ruler! Throw down your weapons or you die! 
Where are they? Where are your friends now? Tell me about the loneliness of good, He-Man. Is it equal to the loneliness of evil? 
Everything comes to he who waits... and I have waited so very long for this moment. 
Your wonderous Sorceress will die! 
I dare anything! I am Skeletor! Throw down your weapons and pledge yourselves to me! Or you will join her! 
Silence! 
Do you hear, Sorceress? The final moment has come. All the forces of Greyskull, all the powers in the universe will be vested in me! ME! And you will cease to exist! 
[speaking of the Great Eye] Madness! I demand of destitution, shame, and loneliness of scorn. It is my destiny! It is my right! Nothing will deter me from it! 
[laughs] Thank you for that bit of philosophy, Sorceress. Here is my response. 
Yes, Sorceress! The Sword of Greyskull! Mine! Now and forever! 
Your champion. 
[to He-Man] Where is your strength? Where has it gone? Look at your precious Sorceress - now grown weak... withering... dying. Are you ready to kneel now, proud warrior?
Do you hear? The Alpha... and the Omega... death and rebirth... and as you die, so will I be reborn!
Witness this moment, He-Man! This moment where the powers of Greyskull will become mine for eternity! Our life-long battle in ending at last in the only way it could. When the Great Eye opens. The people of Eternia will see you kneel before me, just before you die!
Yes, you will! Yes, you will! Or I shall wreak unforgettable harm upon you! 
Leave them alone. He-Man is my slave. As long as I let them live, he is bound by his word. Let them rot. 
Let them rot.
Stay where you are, He-Man! One more move and your friends will not live to see another day! I give you a choice. Return with me to Eternia as my slave and save their miserable lives, or perish with them on this primitive and tasteless planet. Surrender your sword. 
[speaking to the audience] I'll be back!
People of Eternia, the war is over. My forces are victorious. The Sorceress of Greyskull is my prisoner, and her powers are now joined with mine! Let this be my first decree... those who do not pledge themselves to me shall be destroyed! The new age begins! 
I lied! Farewell, He-Man!
EOT;

        $quotes = explode(PHP_EOL, $quotes);

        return implode(
            PHP_EOL,
            [
                sprintf('"<bone>%s</>"', trim($quotes[rand(0, count($quotes))])),
                str_pad('- Skeletor', 47, ' ', STR_PAD_LEFT)
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
