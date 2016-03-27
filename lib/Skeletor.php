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
<red>
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
        $skeletor =  <<<'EOT'
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
        $skeletor = preg_replace('{([\~\:o=\+]+)}', '<bone>\1</>', $skeletor);
        $skeletor = preg_replace('{(\.+)}', '<skeletor>\1</>', $skeletor);
        return $skeletor;
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
Skeletor: People of Eternia! I stand before the Great Eye of the galaxy. Chosen by destiny to receive the powers of Greyskull! This inevitable moment will transpire before your eyes, even as He-Man himself bears witness to it. Now. I, Skeletor, am Master of the Universe! YES! Yes... I feel it, the power... fills me. Yes, I feel the universe within me! I am... I am a part of the cosmos! Its energy flows... flows through me! Of what consequence are you now? This planet, these people, they are nothing to me! The universe is power - pure, unstoppable power! And I am that force, I am that power! KNEEL BEFORE YOUR MASTER! [He-Man refuses] 
Skeletor: Fool! You are no longer my equal! I am more than man! More than life! I... am... a... GOD! Now. You... will... KNELL! KNELL! 
He-Man: I have the power! 
Skeletor: YOU! You will no longer stand between me and my destiny! 
He-Man: But I will! I told you that it's always between us! 
Skeletor: I ache to smash you out of existence! To drive your cursed face from my memories forever! 
He-Man: Enough talk! 
Skeletor: YES! Let this be our final battle! 
Skeletor: Kneel before your master... [He-Man refuses] 
Skeletor: ... fool, you are no longer my equal, I am more than man, more than life... I am a GOD! 
Skeletor: He-Man lives and possesses that key! I must possess all, or I possess nothing! 
Skeletor: You are all aware of the penalty for failure. 
Blade: Give me one more chance, Lord Skeletor, and we will succeed. 
Skeletor: I am not in a giving vein this day. [incinerates Sauron; Beastman grabs his feet, begging for his life] 
Skeletor: GET AWAY! 
Karg: He begs your forgiveness as do we all. We live only to serve you. 
Evil-Lyn: [about the mercenaries] It would be a pity to waste their talents. 
Skeletor: [pushing her away towards them] Save your pity for yourself if you fail. Take them and whatever troops and resources you need. 
Evil-Lyn: I was not suggesting that I go. 
Skeletor: Then you should not have spoken. Leave immediately. When you find the key, send a sourcing signal. An attack force will join you or I will follow. 
Evil-Lyn: After all this time, Greyskull is ours. 
Skeletor: NO! Mine. 
Sorceress: The powers of Greyskull have not yet passed to you. 
Skeletor: Someone is speaking to me... yes. Sorceress, my lovely prisoner, my prisoner at last. I've won. I've won. The darkness is rising to embrace you. 
Sorceress: The dark can embrace the light, but never eclipse it. You've not won yet, Skeletor. He-Man is still alive! I can feel him! 
Skeletor: Really? How sensitive you are. Can you feel - this? [uses his magic to absorb her strength]
Skeletor: Not the way to treat your beloved ruler! Throw down your weapons or you die! 
Skeletor: Where are they? Where are your friends now? Tell me about the loneliness of good, He-Man. Is it equal to the loneliness of evil? 
Skeletor: Everything comes to he who waits... and I have waited so very long for this moment. 
Skeletor: Your wonderous Sorceress will die! 
Duncan: You dare threaten her life? 
Skeletor: I dare anything! I am Skeletor! Throw down your weapons and pledge yourselves to me! Or you will join her! 
He-Man: It's not her you want, it's me. It's always been between us. 
Skeletor: Silence! 
Skeletor: Do you hear, Sorceress? The final moment has come. All the forces of Greyskull, all the powers in the universe will be vested in me! ME! And you will cease to exist! 
Sorceress: It is not too late to undo this madness. 
Skeletor: [speaking of the Great Eye] Madness! I demand of destitution, shame, and loneliness of scorn. It is my destiny! It is my right! Nothing will deter me from it! 
Sorceress: Men who crave power look back over the mistakes of their lives, pile them all together and call it destiny. 
Skeletor: [laughs] Thank you for that bit of philosophy, Sorceress. Here is my response. [Blade brings the Sword of Greyskull forward] 
Skeletor: Yes, Sorceress! The Sword of Greyskull! Mine! Now and forever! [He-Man is brought forward] 
Skeletor: Your champion. 
Skeletor: [to He-Man] Where is your strength? Where has it gone? Look at your precious Sorceress - now grown weak... withering... dying. Are you ready to kneel now, proud warrior? 
Robot Trooper: The moon rises to its zenith. 
Skeletor: Do you hear? The Alpha... and the Omega... death and rebirth... and as you die, so will I be reborn! 
Skeletor: Witness this moment, He-Man! This moment where the powers of Greyskull will become mine for eternity! Our life-long battle in ending at last in the only way it could. When the Great Eye opens. The people of Eternia will see you kneel before me, just before you die! 
He-Man: [lunges towards Skeletor] I'll never kneel to you! 
Skeletor: Yes, you will! Yes, you will! Or I shall wreak unforgettable harm upon you! 
Robot Trooper: [regarding He-Man's allies] What about them, sir? 
Skeletor: Leave them alone. He-Man is my slave. As long as I let them live, he is bound by his word. Let them rot. [laughs] 
Skeletor: Let them rot. 
Skeletor: [laughs]
Skeletor: Stay where you are, He-Man! One more move and your friends will not live to see another day! I give you a choice. Return with me to Eternia as my slave and save their miserable lives, or perish with them on this primitive and tasteless planet. Surrender your sword. [last lines] 
Beast Man: If Batros is so smart, how come he stole the books instead of the gold and the jewels? [chuckles] 
Skeletor: Because unlike you, Batros has a brain. What he has taken is more precious than gold or jewels. 
Beast Man: Books? 
Skeletor: Of course, you worthless hunk of fur. Books are the real treasures of the world. 
Skeletor: Do what I tell you, desert sand, for you are under my command! 
Batros: [referring to Beast Man] I found this one away from home. I thought I'd bring him back to you. 
Skeletor: [snickers] I'm considering putting him on a leash. 
Skeletor: More tricks, Batros? Or are you ready to talk business? 
Batros: You talk, I'll listen. 
Skeletor: I'll talk, and you'll obey! You're clever, Batros. Unlike some of my servants, who can hardly think at all. You have a brain that could warm my heart, if I had a heart. 
Batros: I have a plan. 
Skeletor: You see, Beast Man? Some use their heads for something besides growing fur. 
Skeletor: Struggle all you want, He-Man, that net is made of Elastium. It's not only one of the hardest substances in the universe, but it also stretches. You and your stupid beast are helpless! [Battle Cat growls in defence] 
He-Man: Easy there, old friend. 
Skeletor: As you can see, General, when I require intelligent assistance, I have to look somewhere besides Snake Mountain. That's why I called on you... 
General Tataran: You mean for my brains? 
Skeletor: That, and because you are heartless! When I said heartless, I meant just that. As you are a goblin, I understand you do not have a heart. 
General Tataran: That's true, we don't need them. 
Skeletor: But this time, we're not going to defeat He-Man... 
General Tataran: We're not? 
Skeletor: No, this time He-Man is going to defeat himself! [cackles wickedly] 
Skeletor: [cackles] Foolish Orko! This prison has been magiced proof! None of your pitiful little spells will work on it. 
Skeletor: A mesotronic bomb! 
Teela: That's right. And you have five minutes to get you and your evil cohorts out of here before I press the button. 
Skeletor: You wouldn't dare! 
Teela: And no magic, Evil Face, or I press the button now! 
Teela: You have four minutes left, Skeletor. 
Skeletor: I don't need four minutes to defeat you! [hits Teela with two bolts of magic] 
Skeletor: [cackles wickedly] There is the answer to my evil needs! 
Trap Jaw: Wh-what is it, Skeletor? 
Skeletor: It's a giant spacecraft, tin-head, and it's filled with thousands of Bee-people. If I could capture this spacecraft and enslave all the bee-people, I would have an army large enough to take on Horde-Prime himself! And if I can conquer Horde-Prime, the universe shall be mine! [more laughter] 
Skeletor: Trap Jaw, Beast Man! 
Beast Man: [nervously] Huh, huh, yes, awesome Skeletor? 
Skeletor: Both of you shall accompany me on my invasion of this Hive-ship. Get the sleep gas devises, Beast Man. And Trap Jaw, make sure your sun ray is fully charged. We don't want to hurt anyone, but... we will have got a lot of Bee-people to convince. [chuckles wickedly] 
Skeletor: Sleep gas and stun rays only, my evil henchmen. No one must be hurt. After all, they're going to be joining my army soon! [cackles wickedly] 
Drone 7: Our people are peaceful colonists, you bone-faced monster! We want no part of war or fighting. 
Skeletor: That's too bad, bug-brain, because you are all now part of Skeletor's army! 
Drone 7: You monster! We will never agree to serve you. 
Skeletor: I don't recall giving you a choice, Bee-man. You will be doing as I command, wether you like it... [fires a bolt of persuasion] 
Skeletor: or not! 
Trap Jaw: [watching a view screen] Oh, w-w-what's that? 
Whiplash: Are your brains getting rusty? It's a Wind Raider. 
Trap Jaw: Oh, I know that, you fool, but there's no one flying it. 
Whiplash: Hmm. It's probably another of those new inventions those goody-goodies at the palace keep coming up with. 
Skeletor: [Skeletor enters] Inventions? I always need new inventions! 
Trap Jaw: Yeah, we could use a new Wind Raider. 
Skeletor: You mean I could use a new Wind Raider! 
Trap Jaw: [Skeletor is twirling his Havoc Staff abovie his head] I-I didn't know you could do that! 
Skeletor: I could write a book about what you don't know! 
Skeletor: [about He-Man] He's as weak as a slime-kitten. Even you two could capture him. 
Skeletor: I had to take time off from destroying the swamp people's village, just to rescue you. And you didn't even have He-Man! 
Drak: Snake Mountain. It sounds so glamorous. Tell me about it. 
Skeletor: Well, it's, it's a dark and dismal. 
Trap Jaw: W-w-with slimey walls. Ugh! 
Whiplash: And strange, ugly creatures scurrying around. 
Skeletor: Just like any home, really. 
Skeletor: [conversing through the Window of Spirits] Back up, Muscle-boy! I want to know what you've done to the plants. 
He-Man: Me? 
Skeletor: Yes, because they're bugging the big bones out of me. 
Skeletor: [about Evilseed] Who does that cabbage think he is? 
Mer-Man: Skeletor, if there's a good bone in you, send help! 
Skeletor: There isn't! Never has been, never will be. 
Skeletor: Unite with Castle Grayskull? Never! Never will I set foot in Castle Grayskull until the day I enter as it's conqueror. 
Skeletor: Don't you ever feel like doing something evil? 
He-Man: Don't you ever feel like doing something good? 
Orko: [the heroic warriors have escaped the Tar Swamp] Nice going, He-Man! 
Skeletor: [but the evil warriors are now stuck instead] Nice going, Whiplash! They've gotten away while were stuck in this vile swamp. 
Whiplash: Eh, gee, how'd that happen? 
Skeletor: [leading a procession of 10 Skeletoids] Here comes King Skeletor! [laughs] 
Skeletor: I want you to witness the effects of my genius first hand. 
Skeletor: Give him another ray of weakness! 
Skeletor: Behold: the Evilgizer! It's a little invention I've been toying with. It can increase the evil power of anyone inside it ten times over, making that person the most evil being on Eternia. 
Mer-Man: Sounds like my kind of invention! 
Skeletor: There's just one catch... 
Beast Man: [gasps] uh oh. 
Skeletor: I made the Evilgizer for myself, but then I found that it may have certain unforeseen dangers. 
Mer-Man: On second thought, it's not my kind of invention after all. [Mer-Man leaves] 
Beast Man: Mine neither... [Beast Man backs out, leaving only Spikor] 
Skeletor: A, a volunteer! Contratulation, Spikor. And good luck [chuckles] 
Skeletor: You're going to need it. 
Skeletor: Yes, we'll win this game the old fashioned way, the tried and true way: we'll cheat. [laughs] 
Bendari: To fulfill the test, good will obey it's own rules. But evil will be bound by no rules. 
Skeletor: Then we can do whatever we want! And we will! 
Skeletor: At last I will witness the defeat of He-Man! As long as that fool Spikor doesn't mess things up. 
Spikor: [on intercom] You called, Skeletor? 
Skeletor: Not exactly. 
Skeletor: [through wrist comlink] Well, is it working? 
Beast Man: Unfortunately, yes. 
Skeletor: Hit the button, Maddok! 
Maddok: One bunch of angry chimperella's coming up. 
Skeletor: [to Maddok] And if your contraption doesn't work this time, I'm giving Beast Man his job back. 
Beast Man: [listening in on intercom] Don't work! Don't work! Don't work! Please, don't work! 
Skeletor: When we get back to Snake Mountain, Maddok, I'm gonna show you how angry I can get, without an Anger-Beam. 
Skeletor: With this Gate-Maker I will be able to open a door to Etheria so big, that I can use it to send the entire Royal Palace through, getting rid of everyone all at the same time! [evil laughter] 
Skeletor: Here, She-Ra, a gift: this power bolt was made just for you. [fires his Havok staff] 
Skeletor: Lets see now, which way to find Modulok? [a blaster bolt hits near Skeletor's feet] 
Hordak: Give it up, Skeletor. You couldn't find your own face on a sunny day. 
Skeletor: Hordak! You oversized rust-bucket! 
Hordak: Friendly as ever, eh, Bonehead? 
Skeletor: Hmm. He-Man and She-Ra against Hordak. Hmm, I'm just in time. I could help them, I could work with them instead of against them. We could defeat Hordak together. Hmmm, I think I'll wait and see who wins instead. 
Skeletor: [to Spikor] Well, nail-head, what shall we do to make life miserable for King Randor today? 
Skeletor: Greetings, Hordak. I'm glad to see you. It will give me the pleasure of freezing you in your tracks. 
Hordak: Try it! [snorts] 
Hordak: You bone-headed bog-waddler! 
Skeletor: Chew on this, bolt-breath! 
Skeletor: This is between me and Hordak, woman. 
She-Ra: Sorry, bone-brain, I don't like Hordak, but I wouldn't leave a slime-crawler to your brand of mercy. 
Skeletor: Just like He-Man, always meddling! 
Skeletor: I think I'll make King Randor my court jester when I conquer Eternia. If he's funny enough... [snickers] 
He-Man: Skeletor, follow us to Castle Grayskull. 
Skeletor: I know the way, He-Man. I've been there before [chuckles wickedly] 
Teela: That light what was it. 
He-Man: Another one of the sorceress' travel corridors. Expect that one lead to... 
Skeletor: Snake Mountain you will pay for this He man! 
Skeletor: When I give the word you attack He man I mean all of you. 
Whiplash: Don't worry . 
Skeletor: Form an alliance with you never! 
He-Man: Skeletor you're responsible,and whether you like it or not you are going to help us get rid of that monster. 
Skeletor: Very well we will form an alliance, but only until our task is complete. 
Skeletor: They are ready for transporting, Beast Man. The dragon's eggs. And the dragon pearl... Mer-Man found it in the Slime Swamp. [cackles] 
Skeletor: The fool traded it to me for Eternian silver. He doesn't know it's value. He doesn't know... 
Skeletor: [cackles] I'm so powerful I even impress myself! 
Beast Man: Gah, but you don't impress me. Some day, I'll show you what power really is. 
Skeletor: Did you say something? 
Beast Man: No, nothing, Skeletor. 
Skeletor: Our new home: Castle Grayskull! 
The Sorceress: Go back to Snake Mountain, Skeletor. We have enough trouble without you showing up. 
Skeletor: Trouble? [laughs] 
Skeletor: I'll show you trouble, Sorceress! 
Beast Man: When Skeletor gets his hands on the Starseed, he will finally rule the universe. 
Mer-Man: And I'll be his second in command. 
Beast Man: You? He said I could be second in command. 
Mer-Man: Why would he want a fuzzy faced cretin like you ruling under him, when he could have someone with my brain? 
Beast Man: Why, you fish-faced meathead! 
Skeletor: Silence, fools! The Starseed must be near. Absolute power is within my grasp! 
He-Man: Skeletor! Making that pair do your dirty work? I'm surprised you didn't bring some of your slaves. 
Skeletor: You flipping fool! Within minutes the whole cosmos will be my slave! 
Skeletor: Hear me, oh Starseed. Encase He-Man in chains which not even he can break. Then, send him away to the furthest planet of the coldest star in the universe. 
Skeletor: We're not so far apart, are we, He-Man? 
He-Man: I can... see why you wanted the Starseed so badly. The feeling of power is... very strong. 
Orko: He-Man, what are you saying? 
Skeletor: You're becoming evil, He-Man, I can sense it. Then join forces with me. Together we will rule! 
Beast Man: Who's is he, Skeletor? 
Skeletor: I don't know, but with most of our evil allies in jail, or on missions elsewhere, I could use his sinister power. 
Skeletor: No one says 'no' to Skeletor, fool! I'll force you to serve me. [cackles wickedly] 
Skeletor: After we use this dolt to help us break into Grayskull, you can have him for a slave, Beast Man. 
Beast Man: [laughs] A slave of my own. Now I'll have someone to boss around for a change! [more laughter] 
Skeletor: Another few seconds, and Grayskull is mine! 
Skeletor: Tell me about this army of yours... 
General Tataran: It is a multi-attack force composed of laser-armed airships, jet-packed paratroopers, thunder-lizard cavalry, robot assault walkers and five hundred goblin infantry troups. 
Skeletor: Wonderful! 
Skeletor: [He-Man has evaded Skeletor's powerballs] Ah, you leap like a swamp hopper, He-Man. But you can't avoid them forever. 
He-Man: What's next, Skeletor? 
Skeletor: Oh He-Man, how you vex me! 
Skeletor: Attack He-Man, you filthy beast! 
Skeletor: I want Eternia. All of it! The entire universe! And I'm not one step closer than the day I started! 
Clawful: It's the Sorceress. We'd better get out of here. 
Skeletor: Stand your ground, you crab-faced coward! 
Skeletor: [about Castle Grayskull] I hate this place! 
The Sorceress: Well, Skeletor, have you enjoyed your little visit here? 
Skeletor: Let me out of here, you goody-goody witch, you! 
Skeletor: The Sorceress is in Grayskull, Celice. You will use your siren song to hypnotise her and then sing the jawbridge down. Go! 
Celice: [under Evil-Lyn's spell] You... are... evil... but... I... cannot... resist you. Forgive me, Sorceress... wherever you are... 
He-Man: Leaving so soon? 
Skeletor: Let go of me, flesh-face, or I'll... 
Skeletor: [Skeletor is trapped in a bubble] A zero-G bubble. 
He-Man: I always said you were a lightweight, Skeletor! [laughs heartilly] 
Skeletor: [to Mer-Man] I should banish you to the burning desert, where there's no water! 
Skeletor: If you needed Rainbow Quartz, why didn't you just ask? 
He-Man: I come here in peace. If I can leave that way, it will be a pleasant surprised. 
Skeletor: Not again! I had Teela right in the palm of my hand. [grumbles] 
Skeletor: Why does this always happen to me? 
Skeletor: [reading inscription] Beware the Mirror of Moravad, where bad is good, and good is bad. Where one may come, two depart, but only one may have the heart. 
Kol Darr: It worked! Now I just hope that the mirror did what it's supposed to do, and that you're a good version of Skeletor. 
Skeletor's double: Yes, I am. Here, let me try to get you out. 
Skeletor's double: And what do you think you're doing? 
Beast Man: But you said... 
Skeletor's double: Never mind what I said, just do what I said. 
Colonel Mark Blaze: [gazing upon Snake Mountain] Would you look at that. It looks like something out of a horror movie. It looks like some kind of monument to evil. 
Skeletor: [cackles] A slight correction, intruder: it is a monument to greatness! 
He-Man: Perfect! Soon the knowledge of the universe itself will be in my brain! 
Skeletor: A nice, safe empty place, eh, Skeletor? 
He-Man: He-Man! And another one of those Earth-creatures. 
He-Man: [Andrea has just judo flipped Evil-Lyn] Beautiful, Andrea. Where did you learn that? 
Major Andrea Steele: My father taught me how to cook, my mother taught me judo. 
Skeletor: And I'm about to teach you a lesson. We'll see how brave you talk when Castle Grayskull is mine! 
Skeletor: I'll break the seals and claim it's treasures for myself! Who knows what lurks behind these doors? 
Skeletor: Raven, raven, fly to me. Raven, raven, what did you see? 
Raven: [squawks] To save theselves, I did learn, inside Mount Eternia they return. And find the chamber at all cost, revealing secrets that were lost. 
Skeletor: Aha! The legendary lost secrets, well, I shall find them first! 
Teela: Hold it right there, Bonehead! 
Skeletor: I bid you a fond farewell, forever! [laughs while teleporting away] 
Teela: Still doing your masters dirty work, huh, Clawful? 
Clawful: Skeletor runs things now, but... but some day, some day I'll turn on him. 
Skeletor: Silence! You fishmonger, I'll throw you back in the ocean before you ever rule Snake Mountain! 
Skeletor: Why Glitch, how really unpleasant it is to see you, you sniveling coward. 
Skeletor: You're right, He-Man, it is time I was going. 
King Sallas: Not so fast, you deceitful blaggard. 
Skeletor: You're no match for me, He-Man. [fires his Havoc Staff] 
He-Man: As long as I'm awake, I am! [He-Man evades Skeletor's blast, which cuts a tree in half] 
He-Man: Skeletor, you just shouldn't do that to a living tree! 
Squinch: Keep your promise to make me big, and I'll take on all of ya, single handed! 
Skeletor: Not a chance, little one! 
Skeletor: You'll pay for this, He-Man. 
He-Man: So you keep telling me, Skeletor, but when are you going to learn that evil never really can win? 
Skeletor: Beast Man, can you communicate with that furry pet of yours? 
Beast Man: Of course, Master. I am not the King of Beasts for nothing. 
Skeletor: Beast Man, you clumsy oaf, put your seatbelt on! 
Skeletor: Come back here, I'll make Hollywag pie out of you! I'll turn you into a paperweight! 
The Secret of the Sword (1985)
Skeletor: A female He-Man! Aw-Haw! This is the worst day of my life! 
Skeletor: Skeletor to King Randor, Skeletor to King Randor. Come in, you royal boob! 
Skeletor: You left me with our enemies! 
Hordak: And you betrayed me to those same enemies. So I say we are even. 
Skeletor: Perhaps you are right. 
Skeletor: I cannot control Daimar, so I will conquer him! 
Skeletor: He-Man, you are a fool! Daimar was not born to think, only to serve his superiors. He will follow my orders. 
Skeletor: Join me, Daimar, we'll rule Eternia together! 
Skeletor: Now what am I going to do with a Toy Maker, hm? Take over Eternia with an army of toy bears? [cackles mockingly] 
Toy Maker: Yes, if that is your desire, Skeletor. 
Skeletor: At last, He-Man, I have defeated you. You're doomed. Doomed! Doomed. [evil laughter] 
Skeletor: Eternia is mine! 
He-Man: Noooo! 
Trap Jaw: [Trap Jaw and Beast Man are trapped beneath a giant toy dinosaur] Skeletor, help us! 
Beast Man: Help us, help us! 
Skeletor: No, I'm only interested in saving myself. 
Skeletor: Hm, He-Man wants something, I'll let him in and find out what it is. But what he's going to get won't be what he wants! 
Skeletor: Something's happened to the Sorceress? 
He-Man: [more threatening than usual] You know what happened... [Battle Cat growls] 
Skeletor: But I don't, He-Man, I really don't. I haven't done anything to the Sorceress... recently. 
Skeletor: Tell me, He-Man, do you like falcons? 
He-Man: Falcons? Why? 
Skeletor: Because you're going to have one for company for a very long time! 
Skeletor: It's been, how long? 
Monteeg: Oh, not, not since we've overthrew good King Archibald. 
Skeletor: That's right! [they laugh and snicker] 
Monteeg: Too bad you don't have the same luck with He-Man. 
Skeletor: He-Man is a lucky fool! One day shall destroy him and his friends in the palace. 
Monteeg: I have heard stories, many tales about this He-Man. They say he is stronger than any living mortal. 
Skeletor: Heh! Don't tell me you've come to put him in your army? 
Monteeg: Exactly. [takes a sip of his drink by using his finger] 
Skeletor: But he will resist. He is not like any of your others. 
Monteeg: Don't worry about it, I have my ways. Believe me, he will do what I want. 
Skeletor: Well, take him then. You will be doing me a favor! 
Monteeg: Oh my goodness, that was impressive! 
Skeletor: Impressive, you boob! It was spectacular. You're army is nothing without him. 
Clawful: And you are everything without him! 
Skeletor: Well, I hope He-Man tries to stop us, because this time, we will crush him! [crushes a diamond in his fist to prove his point] 
Skeletor: [on viewscreen] You haven't won yet, He-Man. Your precious Man-At-Arms is still in my not-so-safe keeping. 
"Masters of the Universe vs. the Snake Men: Sweet Smell of Victory (#1.23)" (2003)
Skeletor: I have chosen you to lead my warriors into battle against the palace of Eternia. 
Odiphus: Really? 
Skeletor: You and your wonderful stink-power, are the very key to my new offensive. 
Trap Jaw: Yeah, you're the most offensive thing we've ever smelled. [last lines] 
Skeletor: And you will scrub until every piece of armor is gleaming 
Whiplash: Aww! How come the stinky guy isn't bein' punished too? 
Skeletor: Because, unlike the rest of you, Odiphus has proved himself useful! 
Stinkor: Odiphus? Who's Odiphus? Call me... Stinkor! 
Skeletor: You're crying for Hordak? I don't believe it! 
Noah: How can you cry for someone like him? 
She-Ra: I'm not just crying for Hordak, I'm crying for the saddest thing I know: a wasted life. To be given that most precious gift, the gift of living, to do with as we choose. I'm crying, because this man has chosen to throw it away. And when he goes, nobody will care. 
Skeletor: I hate to leave this touching scene, but I see my plan has failed. I'll be back another time, my 'friend'. 
Skeletor: Confound it! I must find out the source of this infernal rumbling. 
Trap Jaw: [Beast Man & Trap Jaw peek around a corner] We, we weren't mumbling, Skeletor. 
Skeletor: Not mumbling, you meat-heads! Rumbling. Rrrrrumbling! 
Skeletor: Looks like it's moving time for the insect people! [evil laughter] 
Skeletor: Quick, you two. Get out there. 
Beast Man: Duh, you want us to help them move? 
Skeletor: And now, Princess, I must decide what to do with you. 
Adora: Oooh! [pretends to pass out] 
Beast Man: Huh, she's, she's fainted. 
Skeletor: Hah! Just like a woman. 
Skeletor: A female He-Man? This is the worst day of my life! 
Skeletor: Are we flying backwards, beastie? Why haven't we reached Castle Grayskull? 
Colossor: Who has awakened me? 
Skeletor: I, Skeletor, Master of the Universe, have awakened you! 
Zagraz: Oh, you must let me go for goodness sake. 
Skeletor: I never ever do anything for goodness sake. [small chuckle] 
Skeletor: Everything I do, is for the sake of evil. 
Zagraz: But there's some good in everybody. 
Skeletor: Not in this body. [laughs and shakes his fists] 
Skeletor: When are you goody-goody fools going to understand? I am completely and utterly evil. I live to be bad! I care for no one and no one cares for me. 
Skeletor: Forget it, Zagraz is mine. You want him, then you have to fight for him. 
He-Man: [sighs] Fighting is all you ever think about. 
Skeletor: No, you're wrong. I think about ruling all Eternia more than I think about fighting. Fighting is a close second. 
Skeletor: [laughing] At last I won, the wheel spins! 
Skeletor: Fool! You've broken loose the Time Wheel. It will explode! You may have saved Grayskull, but you've doomed yourself! 
Evil-Lyn: Skeletor, this is carrying things too far. 
Skeletor: I am sorry, Evil-Lyn, but capturing He-Man is more important than the personal comfort of those who serve me. 
Skeletor: To capture He-Man, I'd sell out anyone! 
Skeletor: [on viewscreen, laughing] That's solid magnetic force you're trapped in, He-Man! Not even a mega-bomb could dent it. Not only have you lost the disks, you've lost your freedom as well! 
Skeletor: It was torture, wasn't it? To be invisible in the world of men, unable to touch anyone, to speak to anyone? 
Zanthor: It was horrible. 
Skeletor: Then give me the disks! I will free you from the Phantom Dimension forever. And together we will attack Zodac and your other enemies who put you there. 
Zanthor: Zodac is not my enemy, you are, Skeletor! 
Man-At-Arms: I'd still like to know where those monsters came from. 
He-Man: I don't know, but I'll bet you anything Skeletor's mixed up in this. 
Skeletor: Right, He-Fool! 
He-Man: Skeletor! 
King Randor: A Drachadon! They've been extinct for ages. 
Skeletor: Greetings, King Randor. Unless you'd like my pet here to demolish the palace, you'll surrender to me immediately. 
King Randor: [turns to the queen] My dear, in order to protect and the kingdom, I must agree. 
Man-At-Arms: Skeletor, even you couldn't be that cruel? 
Skeletor: Ah, but I can! 
Skeletor: This is becoming a wonderful day for evil! Soon I shall have Teela, Buzz-Off and that silly little bag of wind all in my power. 
Evil-Lyn: He-Man's goodness will prevent him from letting the people of Stone City suffer. He'll see things our way, and then the power of Grayskull will be ours. And the best part it, we won't have to share it with - [turns to see Skeletor enter] 
Evil-Lyn: Ah! Skeletor, how good to see you. 
Skeletor: You've been awfully quiet today, Evil-Lyn. I thought I'd see what you were up to. Hm. What's this? 
Evil-Lyn: Oh... [nervous laughter] 
Evil-Lyn: ... nothing. 
Skeletor: I can see it right in front of me, Evil-Lyn, so it's not nothing. 
He-Man: You're running out of time, Skeletor. Either you return the LifeBringer, or we'll keep widdling away at each level until Snake Mountain becomes Snake Valley. 
Skeletor: Like I said, there's nothing he can say that will convince me... except that. 
Skeletor: Welcome, He-Man. Are you here to pledge your loyalty to the new ruler of Eternia? 
He-Man: You'll be ruling from a dungeon cell when I'm through with you, villain. 
Evil-Lyn: They're gone! But where, how? 
Skeletor: It's the Sorceress, you boob. 
Skeletor: Your mistake will cost you dearly, old enemy. I'm about to rid Eternia of your hated presence forever. You'll feel nothing, He-Man. But you will no longer be a problem to me. By the powers of darkness, evil and fear, I command He-Man's memory to now disappear. 
Skeletor: Doorway, now prove that Skeletor is clever. Sweep He-Man inside you and hold him forever! 
Skeletor: [about to cast another spell on Elmora] Your hatred of me will work in my favor. Every time you look at He-Man you will see my face. And you will think it is me! [evil laughter] 
Orko: Now you're gonna get it! 
Skeletor: No one 'gets' Skeletor. Away! 
Skeletor: The Egg of Avion is mine! Soon we'll all have wings! 
Skeletor: [to He-Man] I have you now, you muscle bound oaf! 
Trap Jaw: It's cold up here! Really cold! 
Beast Man: Uh, yes, boss. Can't you turn up the heat? 
Skeletor: Quiet! I'm trying to think. 
Beast Man: Uh, can't you think when you're warm? 
Skeletor: [raises voice] Quiet! 
Skeletor: [to Beast Man] You furry, flea bitten fool, I'll cover my throne with your hide! 
Mer-Man: Years ago, her guardian, Man-At-Arms, rescued a victim I had chosen for the Sea Demon. I now demand revenge! 
Skeletor: [rises from his throne] So be it! 
Skeletor: When you can move again you can tell your people: if they want Prince Adam back, send He-Man to get him. We'll be in the Banshee Jungle. 
Skeletor: He-Man! You're a fool if you think you can stop me, here. [cackles wickedly] 
Skeletor: Now we're playing in my dimension, and I make all the rules. 
Skeletor: He-Man, your ugly friend sacrificed himself for nothing! 
He-Man: No sacrifice is for nothing, if it helps other people, Skeletor. And your selfishness will be your own undoing! 
Skeletor: [cackles] Honey yours, Kingdom mine, once we take the King's warehouse. 
Skeletor: Some days, nothing goes right! 
Skeletor: [communicating via a magic spell] I have received word that that troublemaker Adam has arrived on the Bright Moon and is attempting to bring peace. 
Evil-Lyn: The nerve of him! 
Trap Jaw: Well, what do you want us to do, Skeletor? 
Skeletor: You must use all your powers to bring misery and despair to the people of the Dark Moon. I... want... war! 
Skeletor: [cackles] Welcome, He-Man. 
He-Man: You said you wanted to talk. 
Skeletor: Of course, He-Man. Just as soon as you escort me into Castle Grayskull. 
He-Man: Never! Give me that magic staff of yours. 
Skeletor: Webstor! Webstor, where are you? 
Webstor: [lowers himself down on a webstrand] I'm right here, boney! 
Skeletor: I have a little job for you, bug face. Pay attention! 
Skeletor: [scolding Whiplash for a botched job] They should call you Wimplash. 
Whiplash: Just give me another chance to get my claws on that Ice Raider. 
Skeletor: Quiet, or I'll turn you into a suitcase! 
Modulok: But why can't I join your gang? 
Skeletor: [on viewscreen] Because you were a wimp scientist and you could be a wimp villain. Prove to me what you can do. Then we'll discuss letting you 'join up'. 
Skeletor: Ah... a people who can built, travel through time, yet are unable to defend themselves... I like that! 
Skeletor: DON'T CALL ME BONEHEAD! 
He-Man and the Masters of the Universe: The Beginning (2002) (TV)
He-Man: Surrender Skeletor. 
Skeletor: Yes... I... I do. [blasts He-Man] 
Skeletor: Had my fingers crossed. 
Skeletor: I will make another He-Man. An evil one called Faker. [and indeed he does with just a flick of his wrist] 
Skeletor: I have done it! A perfect likeness of He-Man. Sometimes my power even amazes me! 
Skeletor: [magical apparition] Stop complaining, go home! The only person who's going to enjoy this circus is me! [cackles evilly] 
Evil-Lyn: [casting a spell of change on Kobra Khan] And now where stands the Kobra Khan, let there be a mortal man! 
Kobra Khan: Niccccccccccccccce. 
Skeletor: [imitating Kobra Khan] Niccccccce? 
Evil-Lyn: I could only change the way he looks, not the way he talks. 
Skeletor: [over intercom] Skreeech, prepare to attack. You will surprise He-Man from above, grab him in your claws and carry him to the lake of Oblivion and drop him in! [cackles] 
Cringer: [quietly] I wish Battle Cat were here... 
Skeletor: Are you ready, my darling Screeech? Attack! 
Skeletor: The storm works it's evil. Soon all Eternia will be devastated and I will reign supreme! 
Evil-Lyn: You mean 'we', Skeletor. 
Skeletor: Only if you do your part right, Evil-Lyn! 
Skeletor: Hmm. Whatever Demos and He-Man seek must have incredible power. I can wait no longer, I must have it for myself! 
Skeletor: [speaking to the audience] I'll be back! 
Skeletor: People of Eternia, the war is over. My forces are victorious. The Sorceress of Greyskull is my prisoner, and her powers are now joined with mine! Let this be my first decree... those who do not pledge themselves to me shall be destroyed! The new age begins! 
He-Man: You promised not to hurt them! 
Skeletor: I lied! Farewell, He-Man! 
Skeletor: Ha! Got you at last, you troublesome tots! 
Skeletor: Drat that Hordak! 
Skeletor: [Skeletor picks up a dog and starts to carry him] I don't know what's coming over me, but whatever it is, I don't like it! 
Skeletor: [the dog licks his face] Stop licking my face, you bratty dog! Get away from me! You're drowning me! 
Alicia: It was nice of you to save Relay, Mr. Skeletor. 
Skeletor: I am *not* nice! 
Skeletor: Tell me more about this "Christmas." 
Miguel: Well, it's a wonderful time of the year. Everyone has lots of fun. 
Skeletor: You mean they get in fights? 
Miguel: No, no - they have fun! 
Skeletor: Fights are fun. I like fights! 
Miguel: And you give each other presents. 
Skeletor: And when you open them, they explode, right? 
Miguel: No! They're nice gifts. 
Skeletor: Nice? Doesn't sound like much fun to me! 
Alicia: Oh, thank you, Mr. Skeletor. You saved us! You really are wonderful. 
Skeletor: Listen - I am not nice, I am not kind, and I am *not* wonderful! 
He-Man: Let 'em go, boneface! 
Skeletor: She-Ra and He-Man! Drat! 
He-Man: We'll take those children. 
Hordak: No, *I'll* take those children! 
Skeletor: Hordak! Double drat! 
Hordak: That's right, Skeletor. I figured you'd show up here! 
He-Man: When you two are finished, *we'll* take the children. 
Skeletor: I don't know what's happening to me, but I must save the children! 
Horde Prime: The arrival of the spirit of Christmas on Eternia may threaten my rule. I don't need any more good will and brotherhood on that planet. Find it and crush it! 
Hordak: Have no fear, great master, I will eliminate this... this Christmas spirit before another day is past. 
Skeletor: You? You can't even handle that musclebound female, She-Ra. 
Hordak: Just a minute. What about the way He-Man handles you, bone-brain? 
Skeletor: Bone-brain? Why you miserable excuse for a villain! 
Skeletor: Oh, oh, I don't think I feel well. 
He-Man: Well, I think you're feeling the Christmas spirit, Skeletor. It makes you feel... good. 
Skeletor: Well I don't like to feel good. I like to feel evil. Oooh. 
She-Ra: Don't worry, Skeletor, Christmas only comes once a year. 
Skeletor: Ah, thank goodness! 
Skeletor: Forwards, my lackeys, in the name of destruction! 
Skeletor: You think you're handy with that sword, huh? Well, try this: 
He-Man: Anything you can pitch, I can hit back. 
Skeletor: Curse you, He-Man. Some day I'll have the power to destroy you. Some day! 
Skeletor: Dolts! Halfwits! Brainless idiots, you couldn't even beat a motley group of gnomes! 
Evil-Lyn: As usual, you overreact, Skeletor. 
Skeletor: How else can I act, when I'm surrounded by such fools! 
Skeletor: Once the Coridite is hot enough, I'll mold it into the image of my own breastplate. When worn against my skin, it will add to my strength a hundred times over, making me mighty enough to crush He-Man! 
Skeletor: Now I have the power! 
Skeletor: This is the way it had to end! With Skeletor triumphant at last! 
Skeletor: Very interesting. So that little floating bag of wind has a secret hidden somewhere... Perhaps we should let this walking lightbulb, Aremesh, do our dirty work for us! [cackles] 
Skeletor: I must find that robotic lightbulb before he gets the secret for himself! 
Evil-Lyn: Hurry, Skeletor! Hurry! 
Skeletor: I am hurrying, I'm hurrying! 
Skeletor: [cackles] Soon the Electroid and that little floating runt will be in my possession! 
Skeletor: Perhaps if I will help you get the secret, you will help me take over Eternia. Agreed? 
Aremesh: It is agreed. 
Orko: Oh no! 
Skeletor: Oh yes! 
Skeletor: [to Beast Man] You overgrown fur coat, you let him get away! 
Skeletor: [to Battle Cat] You overgrown alley cat! [Battle Cat laughs at Skeletor, sounding not unlike Muttley] 
Skeletor: My patience grows thin! [neither Beast Man nor Trap Jaw responds] 
Skeletor: I said, my patience grows thin! 
Beast Man: Uh, uh, uh, grows how? 
Skeletor: Thin! Very thin! 
Trap Jaw: Oh no, boss, you aren't too thin, if anything I'd say you look a little fat. [Skeletor zaps Trap Jaw in the behind with his Havoc Staff] 
Skeletor: You tin-tongued dolt, I'm talking about my patience, not my body. 
Skeletor: Castle Grayskull is the source of ultimate power. Power which must be mine! I have tried to conquer it six times. 
Beast Man: Duh, seven. [Skeletor zaps Beast Man's arm with his Havoc Staff] 
Beast Man: Yow! 
Skeletor: Six, you flea-bitten fur- brain! The first one didn't count, it was only practice. I was teasing the poor fool. 
Beast Man: Huh, I guess He-Man can't take a joke. 
Skeletor: Oh, why do I surround myself with fools? Even the robots are smarter than you. [drops to the ground in exasperation] 
Beast Man, Trap Jaw: He means you! 
Skeletor: [looking up from his position on the floor] I mean both of you, you pathetic pair of pitiful pinheads! 
Skeletor: Beast Man, go get the power chains. We don't want our guests to escape. 
Beast Man: Right, Skeletor, I will chain them up tight. I'm very good at that. 
Skeletor: I hope so. You must be good for something. 
Skeletor: Make ready to attack, men. Beast Man, you fly the Collector. Be ready to scoop up the guards as we conquer them. 
Beast Man: Right, Skeletor. [exits for the Collector] 
Skeletor: Trap Jaw, you will control the robot ships from the Basher. Trap Jaw: Right, boss. [exits for the Basher] 
Skeletor: And I myself shall lead the attack in the Doom Buster! 
Skeletor: It's a pity that your chains prevent you from bowing before the new king of Eternia.
Teela: It's a pity these chains prevent me from getting my hands on you, you hooded hoodlum! 
Beast Man: If Batros is so smart, how come he stole the books instead of the gold and the jewels? [chuckles] 
Skeletor: Because unlike you, Batros has a brain. What he has taken is more precious than gold or jewels. 
Beast Man: Books? 
Skeletor: Of course, you worthless hunk of fur. Books are the real treasures of the world. 
Skeletor: Do what I tell you, desert sand, for you are under my command! 
Batros: [referring to Beast Man] I found this one away from home. I thought I'd bring him back to you. 
Skeletor: [snickers] I'm considering putting him on a leash. 
Skeletor: More tricks, Batros? Or are you ready to talk business? 
Batros: You talk, I'll listen. 
Skeletor: I'll talk, and you'll obey! You're clever, Batros. Unlike some of my servants, who can hardly think at all. You have a brain that could warm my heart, if I had a heart. 
Batros: I have a plan. 
Skeletor: You see, Beast Man? Some use their heads for something besides growing fur. 
Skeletor: Struggle all you want, He-Man, that net is made of Elastium. It's not only one of the hardest substances in the universe, but it also stretches. You and your stupid beast are helpless! [Battle Cat growls in defence] 
He-Man: Easy there, old friend. 
Skeletor: As you can see, General, when I require intelligent assistance, I have to look somewhere besides Snake Mountain. That's why I called on you... 
General Tataran: You mean for my brains? 
Skeletor: That, and because you are heartless! When I said heartless, I meant just that. As you are a goblin, I understand you do not have a heart. 
General Tataran: That's true, we don't need them. 
Skeletor: But this time, we're not going to defeat He-Man... 
General Tataran: We're not? 
Skeletor: No, this time He-Man is going to defeat himself! [cackles wickedly] 
Skeletor: [cackles] Foolish Orko! This prison has been magiced proof! None of your pitiful little spells will work on it. 
Skeletor: A mesotronic bomb! 
Teela: That's right. And you have five minutes to get you and your evil cohorts out of here before I press the button. 
Skeletor: You wouldn't dare! 
Teela: And no magic, Evil Face, or I press the button now! 
Teela: You have four minutes left, Skeletor. 
Skeletor: I don't need four minutes to defeat you! [hits Teela with two bolts of magic] 
Skeletor: [cackles wickedly] There is the answer to my evil needs! 
Trap Jaw: Wh-what is it, Skeletor? 
Skeletor: It's a giant spacecraft, tin-head, and it's filled with thousands of Bee-people. If I could capture this spacecraft and enslave all the bee-people, I would have an army large enough to take on Horde-Prime himself! And if I can conquer Horde-Prime, the universe shall be mine! [more laughter] 
Skeletor: Trap Jaw, Beast Man! 
Beast Man: [nervously] Huh, huh, yes, awesome Skeletor? 
Skeletor: Both of you shall accompany me on my invasion of this Hive-ship. Get the sleep gas devises, Beast Man. And Trap Jaw, make sure your sun ray is fully charged. We don't want to hurt anyone, but... we will have got a lot of Bee-people to convince. [chuckles wickedly] 
Skeletor: Sleep gas and stun rays only, my evil henchmen. No one must be hurt. After all, they're going to be joining my army soon! [cackles wickedly] 
Drone 7: Our people are peaceful colonists, you bone-faced monster! We want no part of war or fighting. 
Skeletor: That's too bad, bug-brain, because you are all now part of Skeletor's army! 
Drone 7: You monster! We will never agree to serve you. 
Skeletor: I don't recall giving you a choice, Bee-man. You will be doing as I command, wether you like it... [fires a bolt of persuasion] 
Skeletor: or not! 
Trap Jaw: [watching a view screen] Oh, w-w-what's that? 
Whiplash: Are your brains getting rusty? It's a Wind Raider. 
Trap Jaw: Oh, I know that, you fool, but there's no one flying it. 
Whiplash: Hmm. It's probably another of those new inventions those goody-goodies at the palace keep coming up with. 
Skeletor: [Skeletor enters] Inventions? I always need new inventions! 
Trap Jaw: Yeah, we could use a new Wind Raider. 
Skeletor: You mean I could use a new Wind Raider! 
Trap Jaw: [Skeletor is twirling his Havoc Staff abovie his head] I-I didn't know you could do that! 
Skeletor: I could write a book about what you don't know! 
Skeletor: [about He-Man] He's as weak as a slime-kitten. Even you two could capture him. 
Skeletor: I had to take time off from destroying the swamp people's village, just to rescue you. And you didn't even have He-Man! 
Drak: Snake Mountain. It sounds so glamorous. Tell me about it. 
Skeletor: Well, it's, it's a dark and dismal. 
Trap Jaw: W-w-with slimey walls. Ugh! 
Whiplash: And strange, ugly creatures scurrying around. 
Skeletor: Just like any home, really. 
Skeletor: [conversing through the Window of Spirits] Back up, Muscle-boy! I want to know what you've done to the plants. 
He-Man: Me? 
Skeletor: Yes, because they're bugging the big bones out of me. 
Skeletor: [about Evilseed] Who does that cabbage think he is? 
Mer-Man: Skeletor, if there's a good bone in you, send help! 
Skeletor: There isn't! Never has been, never will be. 
Skeletor: Unite with Castle Grayskull? Never! Never will I set foot in Castle Grayskull until the day I enter as it's conqueror. 
Skeletor: Don't you ever feel like doing something evil? 
He-Man: Don't you ever feel like doing something good? 
Orko: [the heroic warriors have escaped the Tar Swamp] Nice going, He-Man! 
Skeletor: [but the evil warriors are now stuck instead] Nice going, Whiplash! They've gotten away while were stuck in this vile swamp. 
Whiplash: Eh, gee, how'd that happen? 
Skeletor: [leading a procession of 10 Skeletoids] Here comes King Skeletor! [laughs] 
Skeletor: I want you to witness the effects of my genius first hand. 
Skeletor: Give him another ray of weakness! 
Skeletor: Behold: the Evilgizer! It's a little invention I've been toying with. It can increase the evil power of anyone inside it ten times over, making that person the most evil being on Eternia. 
Mer-Man: Sounds like my kind of invention! 
Skeletor: There's just one catch... 
Beast Man: [gasps] uh oh. 
Skeletor: I made the Evilgizer for myself, but then I found that it may have certain unforeseen dangers. 
Mer-Man: On second thought, it's not my kind of invention after all. [Mer-Man leaves] 
Beast Man: Mine neither... [Beast Man backs out, leaving only Spikor] 
Skeletor: A, a volunteer! Contratulation, Spikor. And good luck [chuckles] 
Skeletor: You're going to need it. 
Skeletor: Yes, we'll win this game the old fashioned way, the tried and true way: we'll cheat. [laughs] 
Bendari: To fulfill the test, good will obey it's own rules. But evil will be bound by no rules. 
Skeletor: Then we can do whatever we want! And we will! 
Skeletor: At last I will witness the defeat of He-Man! As long as that fool Spikor doesn't mess things up. 
Spikor: [on intercom] You called, Skeletor? 
Skeletor: Not exactly. 
Skeletor: [through wrist comlink] Well, is it working? 
Beast Man: Unfortunately, yes. 
Skeletor: Hit the button, Maddok! 
Maddok: One bunch of angry chimperella's coming up. 
Skeletor: [to Maddok] And if your contraption doesn't work this time, I'm giving Beast Man his job back. 
Beast Man: [listening in on intercom] Don't work! Don't work! Don't work! Please, don't work! 
Skeletor: When we get back to Snake Mountain, Maddok, I'm gonna show you how angry I can get, without an Anger-Beam. 
Skeletor: With this Gate-Maker I will be able to open a door to Etheria so big, that I can use it to send the entire Royal Palace through, getting rid of everyone all at the same time! [evil laughter] 
Skeletor: Here, She-Ra, a gift: this power bolt was made just for you. [fires his Havok staff] 
Skeletor: Lets see now, which way to find Modulok? [a blaster bolt hits near Skeletor's feet] 
Hordak: Give it up, Skeletor. You couldn't find your own face on a sunny day. 
Skeletor: Hordak! You oversized rust-bucket! 
Hordak: Friendly as ever, eh, Bonehead? 
Skeletor: Hmm. He-Man and She-Ra against Hordak. Hmm, I'm just in time. I could help them, I could work with them instead of against them. We could defeat Hordak together. Hmmm, I think I'll wait and see who wins instead. 
Skeletor: [to Spikor] Well, nail-head, what shall we do to make life miserable for King Randor today? 
Skeletor: Greetings, Hordak. I'm glad to see you. It will give me the pleasure of freezing you in your tracks. 
Hordak: Try it! [snorts] 
Hordak: You bone-headed bog-waddler! 
Skeletor: Chew on this, bolt-breath! 
Skeletor: This is between me and Hordak, woman. 
She-Ra: Sorry, bone-brain, I don't like Hordak, but I wouldn't leave a slime-crawler to your brand of mercy. 
Skeletor: Just like He-Man, always meddling! 
Skeletor: I think I'll make King Randor my court jester when I conquer Eternia. If he's funny enough... [snickers] 
He-Man: Skeletor, follow us to Castle Grayskull. 
Skeletor: I know the way, He-Man. I've been there before [chuckles wickedly] 
Teela: That light what was it. 
He-Man: Another one of the sorceress' travel corridors. Expect that one lead to... 
Skeletor: Snake Mountain you will pay for this He man! 
Skeletor: When I give the word you attack He man I mean all of you. 
Whiplash: Don't worry . 
Skeletor: Form an alliance with you never! 
He-Man: Skeletor you're responsible,and whether you like it or not you are going to help us get rid of that monster. 
Skeletor: Very well we will form an alliance, but only until our task is complete. 
Skeletor: They are ready for transporting, Beast Man. The dragon's eggs. And the dragon pearl... Mer-Man found it in the Slime Swamp. [cackles] 
Skeletor: The fool traded it to me for Eternian silver. He doesn't know it's value. He doesn't know... 
Skeletor: [cackles] I'm so powerful I even impress myself! 
Beast Man: Gah, but you don't impress me. Some day, I'll show you what power really is. 
Skeletor: Did you say something? 
Beast Man: No, nothing, Skeletor. 
Skeletor: Our new home: Castle Grayskull! 
The Sorceress: Go back to Snake Mountain, Skeletor. We have enough trouble without you showing up. 
Skeletor: Trouble? [laughs] 
Skeletor: I'll show you trouble, Sorceress! 
Beast Man: When Skeletor gets his hands on the Starseed, he will finally rule the universe. 
Mer-Man: And I'll be his second in command. 
Beast Man: You? He said I could be second in command. 
Mer-Man: Why would he want a fuzzy faced cretin like you ruling under him, when he could have someone with my brain? 
Beast Man: Why, you fish-faced meathead! 
Skeletor: Silence, fools! The Starseed must be near. Absolute power is within my grasp! 
He-Man: Skeletor! Making that pair do your dirty work? I'm surprised you didn't bring some of your slaves. 
Skeletor: You flipping fool! Within minutes the whole cosmos will be my slave! 
Skeletor: Hear me, oh Starseed. Encase He-Man in chains which not even he can break. Then, send him away to the furthest planet of the coldest star in the universe. 
Skeletor: We're not so far apart, are we, He-Man? 
He-Man: I can... see why you wanted the Starseed so badly. The feeling of power is... very strong. 
Orko: He-Man, what are you saying? 
Skeletor: You're becoming evil, He-Man, I can sense it. Then join forces with me. Together we will rule! 
Beast Man: Who's is he, Skeletor? 
Skeletor: I don't know, but with most of our evil allies in jail, or on missions elsewhere, I could use his sinister power. 
Skeletor: No one says 'no' to Skeletor, fool! I'll force you to serve me. [cackles wickedly] 
Skeletor: After we use this dolt to help us break into Grayskull, you can have him for a slave, Beast Man. 
Beast Man: [laughs] A slave of my own. Now I'll have someone to boss around for a change! [more laughter] 
Skeletor: Another few seconds, and Grayskull is mine! 
Skeletor: Tell me about this army of yours... 
General Tataran: It is a multi-attack force composed of laser-armed airships, jet-packed paratroopers, thunder-lizard cavalry, robot assault walkers and five hundred goblin infantry troups. 
Skeletor: Wonderful! 
Skeletor: [He-Man has evaded Skeletor's powerballs] Ah, you leap like a swamp hopper, He-Man. But you can't avoid them forever. 
He-Man: What's next, Skeletor? 
Skeletor: Oh He-Man, how you vex me! 
Skeletor: Attack He-Man, you filthy beast! 
Skeletor: I want Eternia. All of it! The entire universe! And I'm not one step closer than the day I started! 
Clawful: It's the Sorceress. We'd better get out of here. 
Skeletor: Stand your ground, you crab-faced coward! 
Skeletor: [about Castle Grayskull] I hate this place! 
The Sorceress: Well, Skeletor, have you enjoyed your little visit here? 
Skeletor: Let me out of here, you goody-goody witch, you! 
Skeletor: The Sorceress is in Grayskull, Celice. You will use your siren song to hypnotise her and then sing the jawbridge down. Go! 
Celice: [under Evil-Lyn's spell] You... are... evil... but... I... cannot... resist you. Forgive me, Sorceress... wherever you are... 
He-Man: Leaving so soon? 
Skeletor: Let go of me, flesh-face, or I'll... 
Skeletor: [Skeletor is trapped in a bubble] A zero-G bubble. 
He-Man: I always said you were a lightweight, Skeletor! [laughs heartilly] 
Skeletor: [to Mer-Man] I should banish you to the burning desert, where there's no water! 
Skeletor: If you needed Rainbow Quartz, why didn't you just ask? 
He-Man: I come here in peace. If I can leave that way, it will be a pleasant surprised. 
Skeletor: Not again! I had Teela right in the palm of my hand. [grumbles] 
Skeletor: Why does this always happen to me? 
Skeletor: [reading inscription] Beware the Mirror of Moravad, where bad is good, and good is bad. Where one may come, two depart, but only one may have the heart. 
Kol Darr: It worked! Now I just hope that the mirror did what it's supposed to do, and that you're a good version of Skeletor. 
Skeletor's double: Yes, I am. Here, let me try to get you out. 
Skeletor's double: And what do you think you're doing? 
Beast Man: But you said... 
Skeletor's double: Never mind what I said, just do what I said. 
Colonel Mark Blaze: [gazing upon Snake Mountain] Would you look at that. It looks like something out of a horror movie. It looks like some kind of monument to evil. 
Skeletor: [cackles] A slight correction, intruder: it is a monument to greatness! 
He-Man: Perfect! Soon the knowledge of the universe itself will be in my brain! 
Skeletor: A nice, safe empty place, eh, Skeletor? 
He-Man: He-Man! And another one of those Earth-creatures. 
He-Man: [Andrea has just judo flipped Evil-Lyn] Beautiful, Andrea. Where did you learn that? 
Major Andrea Steele: My father taught me how to cook, my mother taught me judo. 
Skeletor: And I'm about to teach you a lesson. We'll see how brave you talk when Castle Grayskull is mine! 
Skeletor: I'll break the seals and claim it's treasures for myself! Who knows what lurks behind these doors? 
Skeletor: Raven, raven, fly to me. Raven, raven, what did you see? 
Raven: [squawks] To save theselves, I did learn, inside Mount Eternia they return. And find the chamber at all cost, revealing secrets that were lost. 
Skeletor: Aha! The legendary lost secrets, well, I shall find them first! 
Teela: Hold it right there, Bonehead! 
Skeletor: I bid you a fond farewell, forever! [laughs while teleporting away] 
Teela: Still doing your masters dirty work, huh, Clawful? 
Clawful: Skeletor runs things now, but... but some day, some day I'll turn on him. 
Skeletor: Silence! You fishmonger, I'll throw you back in the ocean before you ever rule Snake Mountain! 
Skeletor: Why Glitch, how really unpleasant it is to see you, you sniveling coward. 
Skeletor: You're right, He-Man, it is time I was going. 
King Sallas: Not so fast, you deceitful blaggard. 
Skeletor: You're no match for me, He-Man. [fires his Havoc Staff] 
He-Man: As long as I'm awake, I am! [He-Man evades Skeletor's blast, which cuts a tree in half] 
He-Man: Skeletor, you just shouldn't do that to a living tree! 
Squinch: Keep your promise to make me big, and I'll take on all of ya, single handed! 
Skeletor: Not a chance, little one! 
Skeletor: You'll pay for this, He-Man. 
He-Man: So you keep telling me, Skeletor, but when are you going to learn that evil never really can win? 
Skeletor: Beast Man, can you communicate with that furry pet of yours? 
Beast Man: Of course, Master. I am not the King of Beasts for nothing. 
Skeletor: Beast Man, you clumsy oaf, put your seatbelt on! 
Skeletor: Come back here, I'll make Hollywag pie out of you! I'll turn you into a paperweight! 
The Secret of the Sword (1985)
Skeletor: A female He-Man! Aw-Haw! This is the worst day of my life! 
Skeletor: Skeletor to King Randor, Skeletor to King Randor. Come in, you royal boob! 
Skeletor: You left me with our enemies! 
Hordak: And you betrayed me to those same enemies. So I say we are even. 
Skeletor: Perhaps you are right. 
Skeletor: I cannot control Daimar, so I will conquer him! 
Skeletor: He-Man, you are a fool! Daimar was not born to think, only to serve his superiors. He will follow my orders. 
Skeletor: Join me, Daimar, we'll rule Eternia together! 
Skeletor: Now what am I going to do with a Toy Maker, hm? Take over Eternia with an army of toy bears? [cackles mockingly] 
Toy Maker: Yes, if that is your desire, Skeletor. 
Skeletor: At last, He-Man, I have defeated you. You're doomed. Doomed! Doomed. [evil laughter] 
Skeletor: Eternia is mine! 
He-Man: Noooo! 
Trap Jaw: [Trap Jaw and Beast Man are trapped beneath a giant toy dinosaur] Skeletor, help us! 
Beast Man: Help us, help us! 
Skeletor: No, I'm only interested in saving myself. 
Skeletor: Hm, He-Man wants something, I'll let him in and find out what it is. But what he's going to get won't be what he wants! 
Skeletor: Something's happened to the Sorceress? 
He-Man: [more threatening than usual] You know what happened... [Battle Cat growls] 
Skeletor: But I don't, He-Man, I really don't. I haven't done anything to the Sorceress... recently. 
Skeletor: Tell me, He-Man, do you like falcons? 
He-Man: Falcons? Why? 
Skeletor: Because you're going to have one for company for a very long time! 
Skeletor: It's been, how long? 
Monteeg: Oh, not, not since we've overthrew good King Archibald. 
Skeletor: That's right! [they laugh and snicker] 
Monteeg: Too bad you don't have the same luck with He-Man. 
Skeletor: He-Man is a lucky fool! One day shall destroy him and his friends in the palace. 
Monteeg: I have heard stories, many tales about this He-Man. They say he is stronger than any living mortal. 
Skeletor: Heh! Don't tell me you've come to put him in your army? 
Monteeg: Exactly. [takes a sip of his drink by using his finger] 
Skeletor: But he will resist. He is not like any of your others. 
Monteeg: Don't worry about it, I have my ways. Believe me, he will do what I want. 
Skeletor: Well, take him then. You will be doing me a favor! 
Monteeg: Oh my goodness, that was impressive! 
Skeletor: Impressive, you boob! It was spectacular. You're army is nothing without him. 
Clawful: And you are everything without him! 
Skeletor: Well, I hope He-Man tries to stop us, because this time, we will crush him! [crushes a diamond in his fist to prove his point] 
Skeletor: [on viewscreen] You haven't won yet, He-Man. Your precious Man-At-Arms is still in my not-so-safe keeping. 
"Masters of the Universe vs. the Snake Men: Sweet Smell of Victory (#1.23)" (2003)
Skeletor: I have chosen you to lead my warriors into battle against the palace of Eternia. 
Odiphus: Really? 
Skeletor: You and your wonderful stink-power, are the very key to my new offensive. 
Trap Jaw: Yeah, you're the most offensive thing we've ever smelled. [last lines] 
Skeletor: And you will scrub until every piece of armor is gleaming 
Whiplash: Aww! How come the stinky guy isn't bein' punished too? 
Skeletor: Because, unlike the rest of you, Odiphus has proved himself useful! 
Stinkor: Odiphus? Who's Odiphus? Call me... Stinkor! 
Skeletor: You're crying for Hordak? I don't believe it! 
Noah: How can you cry for someone like him? 
She-Ra: I'm not just crying for Hordak, I'm crying for the saddest thing I know: a wasted life. To be given that most precious gift, the gift of living, to do with as we choose. I'm crying, because this man has chosen to throw it away. And when he goes, nobody will care. 
Skeletor: I hate to leave this touching scene, but I see my plan has failed. I'll be back another time, my 'friend'. 
Skeletor: Confound it! I must find out the source of this infernal rumbling. 
Trap Jaw: [Beast Man & Trap Jaw peek around a corner] We, we weren't mumbling, Skeletor. 
Skeletor: Not mumbling, you meat-heads! Rumbling. Rrrrrumbling! 
Skeletor: Looks like it's moving time for the insect people! [evil laughter] 
Skeletor: Quick, you two. Get out there. 
Beast Man: Duh, you want us to help them move? 
Skeletor: And now, Princess, I must decide what to do with you. 
Adora: Oooh! [pretends to pass out] 
Beast Man: Huh, she's, she's fainted. 
Skeletor: Hah! Just like a woman. 
Skeletor: A female He-Man? This is the worst day of my life! 
Skeletor: Are we flying backwards, beastie? Why haven't we reached Castle Grayskull? 
Colossor: Who has awakened me? 
Skeletor: I, Skeletor, Master of the Universe, have awakened you! 
Zagraz: Oh, you must let me go for goodness sake. 
Skeletor: I never ever do anything for goodness sake. [small chuckle] 
Skeletor: Everything I do, is for the sake of evil. 
Zagraz: But there's some good in everybody. 
Skeletor: Not in this body. [laughs and shakes his fists] 
Skeletor: When are you goody-goody fools going to understand? I am completely and utterly evil. I live to be bad! I care for no one and no one cares for me. 
Skeletor: Forget it, Zagraz is mine. You want him, then you have to fight for him. 
He-Man: [sighs] Fighting is all you ever think about. 
Skeletor: No, you're wrong. I think about ruling all Eternia more than I think about fighting. Fighting is a close second. 
Skeletor: [laughing] At last I won, the wheel spins! 
Skeletor: Fool! You've broken loose the Time Wheel. It will explode! You may have saved Grayskull, but you've doomed yourself! 
Evil-Lyn: Skeletor, this is carrying things too far. 
Skeletor: I am sorry, Evil-Lyn, but capturing He-Man is more important than the personal comfort of those who serve me. 
Skeletor: To capture He-Man, I'd sell out anyone! 
Skeletor: [on viewscreen, laughing] That's solid magnetic force you're trapped in, He-Man! Not even a mega-bomb could dent it. Not only have you lost the disks, you've lost your freedom as well! 
Skeletor: It was torture, wasn't it? To be invisible in the world of men, unable to touch anyone, to speak to anyone? 
Zanthor: It was horrible. 
Skeletor: Then give me the disks! I will free you from the Phantom Dimension forever. And together we will attack Zodac and your other enemies who put you there. 
Zanthor: Zodac is not my enemy, you are, Skeletor! 
Man-At-Arms: I'd still like to know where those monsters came from. 
He-Man: I don't know, but I'll bet you anything Skeletor's mixed up in this. 
Skeletor: Right, He-Fool! 
He-Man: Skeletor! 
King Randor: A Drachadon! They've been extinct for ages. 
Skeletor: Greetings, King Randor. Unless you'd like my pet here to demolish the palace, you'll surrender to me immediately. 
King Randor: [turns to the queen] My dear, in order to protect and the kingdom, I must agree. 
Man-At-Arms: Skeletor, even you couldn't be that cruel? 
Skeletor: Ah, but I can! 
Skeletor: This is becoming a wonderful day for evil! Soon I shall have Teela, Buzz-Off and that silly little bag of wind all in my power. 
Evil-Lyn: He-Man's goodness will prevent him from letting the people of Stone City suffer. He'll see things our way, and then the power of Grayskull will be ours. And the best part it, we won't have to share it with - [turns to see Skeletor enter] 
Evil-Lyn: Ah! Skeletor, how good to see you. 
Skeletor: You've been awfully quiet today, Evil-Lyn. I thought I'd see what you were up to. Hm. What's this? 
Evil-Lyn: Oh... [nervous laughter] 
Evil-Lyn: ... nothing. 
Skeletor: I can see it right in front of me, Evil-Lyn, so it's not nothing. 
He-Man: You're running out of time, Skeletor. Either you return the LifeBringer, or we'll keep widdling away at each level until Snake Mountain becomes Snake Valley. 
Skeletor: Like I said, there's nothing he can say that will convince me... except that. 
Skeletor: Welcome, He-Man. Are you here to pledge your loyalty to the new ruler of Eternia? 
He-Man: You'll be ruling from a dungeon cell when I'm through with you, villain. 
Evil-Lyn: They're gone! But where, how? 
Skeletor: It's the Sorceress, you boob. 
Skeletor: Your mistake will cost you dearly, old enemy. I'm about to rid Eternia of your hated presence forever. You'll feel nothing, He-Man. But you will no longer be a problem to me. By the powers of darkness, evil and fear, I command He-Man's memory to now disappear. 
Skeletor: Doorway, now prove that Skeletor is clever. Sweep He-Man inside you and hold him forever! 
Skeletor: [about to cast another spell on Elmora] Your hatred of me will work in my favor. Every time you look at He-Man you will see my face. And you will think it is me! [evil laughter] 
Orko: Now you're gonna get it! 
Skeletor: No one 'gets' Skeletor. Away! 
Skeletor: The Egg of Avion is mine! Soon we'll all have wings! 
Skeletor: [to He-Man] I have you now, you muscle bound oaf! 
Trap Jaw: It's cold up here! Really cold! 
Beast Man: Uh, yes, boss. Can't you turn up the heat? 
Skeletor: Quiet! I'm trying to think. 
Beast Man: Uh, can't you think when you're warm? 
Skeletor: [raises voice] Quiet! 
Skeletor: [to Beast Man] You furry, flea bitten fool, I'll cover my throne with your hide! 
Mer-Man: Years ago, her guardian, Man-At-Arms, rescued a victim I had chosen for the Sea Demon. I now demand revenge! 
Skeletor: [rises from his throne] So be it! 
Skeletor: When you can move again you can tell your people: if they want Prince Adam back, send He-Man to get him. We'll be in the Banshee Jungle. 
Skeletor: He-Man! You're a fool if you think you can stop me, here. [cackles wickedly] 
Skeletor: Now we're playing in my dimension, and I make all the rules. 
Skeletor: He-Man, your ugly friend sacrificed himself for nothing! 
He-Man: No sacrifice is for nothing, if it helps other people, Skeletor. And your selfishness will be your own undoing! 
Skeletor: [cackles] Honey yours, Kingdom mine, once we take the King's warehouse. 
Skeletor: Some days, nothing goes right! 
Skeletor: [communicating via a magic spell] I have received word that that troublemaker Adam has arrived on the Bright Moon and is attempting to bring peace. 
Evil-Lyn: The nerve of him! 
Trap Jaw: Well, what do you want us to do, Skeletor? 
Skeletor: You must use all your powers to bring misery and despair to the people of the Dark Moon. I... want... war! 
Skeletor: [cackles] Welcome, He-Man. 
He-Man: You said you wanted to talk. 
Skeletor: Of course, He-Man. Just as soon as you escort me into Castle Grayskull. 
He-Man: Never! Give me that magic staff of yours. 
Skeletor: Webstor! Webstor, where are you? 
Webstor: [lowers himself down on a webstrand] I'm right here, boney! 
Skeletor: I have a little job for you, bug face. Pay attention! 
Skeletor: [scolding Whiplash for a botched job] They should call you Wimplash. 
Whiplash: Just give me another chance to get my claws on that Ice Raider. 
Skeletor: Quiet, or I'll turn you into a suitcase! 
Modulok: But why can't I join your gang? 
Skeletor: [on viewscreen] Because you were a wimp scientist and you could be a wimp villain. Prove to me what you can do. Then we'll discuss letting you 'join up'. 
Skeletor: Ah... a people who can built, travel through time, yet are unable to defend themselves... I like that! 
Skeletor: DON'T CALL ME BONEHEAD! 
He-Man and the Masters of the Universe: The Beginning (2002) (TV)
He-Man: Surrender Skeletor. 
Skeletor: Yes... I... I do. [blasts He-Man] 
Skeletor: Had my fingers crossed. 
Skeletor: I will make another He-Man. An evil one called Faker. [and indeed he does with just a flick of his wrist] 
Skeletor: I have done it! A perfect likeness of He-Man. Sometimes my power even amazes me! 
Skeletor: [magical apparition] Stop complaining, go home! The only person who's going to enjoy this circus is me! [cackles evilly] 
Evil-Lyn: [casting a spell of change on Kobra Khan] And now where stands the Kobra Khan, let there be a mortal man! 
Kobra Khan: Niccccccccccccccce. 
Skeletor: [imitating Kobra Khan] Niccccccce? 
Evil-Lyn: I could only change the way he looks, not the way he talks. 
Skeletor: [over intercom] Skreeech, prepare to attack. You will surprise He-Man from above, grab him in your claws and carry him to the lake of Oblivion and drop him in! [cackles] 
Cringer: [quietly] I wish Battle Cat were here... 
Skeletor: Are you ready, my darling Screeech? Attack! 
Skeletor: The storm works it's evil. Soon all Eternia will be devastated and I will reign supreme! 
Evil-Lyn: You mean 'we', Skeletor. 
Skeletor: Only if you do your part right, Evil-Lyn! 
Skeletor: Hmm. Whatever Demos and He-Man seek must have incredible power. I can wait no longer, I must have it for myself! 
EOT;

        $quotes = explode(PHP_EOL, $quotes);
        $quote = trim($quotes[rand(0, count($quotes))]);
        preg_match('{^(.*?): (.*)$}', $quote, $matches);

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
