-- MySQL dump 10.11
--
-- Host: 208.97.162.240    Database: tweettwoscreens
-- ------------------------------------------------------
-- Server version	5.1.56-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blacklist`
--

DROP TABLE IF EXISTS `blacklist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `blacklist` (
  `username` varchar(50) DEFAULT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `blacklist`
--

LOCK TABLES `blacklist` WRITE;
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
INSERT INTO `blacklist` VALUES ('arrypottah'),('bamagirlruns'),('cassthe_bass'),('eltriola'),('funnyquotees'),('ikilledbill__'),('keeleythecunt'),('legendofpotter'),('selfpic_wankers'),('wjxtelizabeth');
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;
UNLOCK TABLES;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `blacklist_insert` BEFORE INSERT ON `blacklist` FOR EACH ROW set NEW.username = lower(NEW.username) */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `blacklist_tweets` AFTER INSERT ON `blacklist` FOR EACH ROW BEGIN
      DECLARE theid INT;
      SET theid = (SELECT `id` FROM users where users.username = NEW.username LIMIT 1);
      DELETE FROM tweets where user_id = theid;
    END */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `blacklist_update` BEFORE UPDATE ON `blacklist` FOR EACH ROW set NEW.username = lower(NEW.username) */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `keywords` (
  `phrase` varchar(30) DEFAULT NULL,
  UNIQUE KEY `phrase` (`phrase`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `keywords`
--

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
INSERT INTO `keywords` VALUES ('@mattgerstman'),('Harry Potter');
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profanity`
--

DROP TABLE IF EXISTS `profanity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `profanity` (
  `word` varchar(100) NOT NULL,
  `user` text,
  UNIQUE KEY `word` (`word`),
  UNIQUE KEY `word_2` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `profanity`
--

LOCK TABLES `profanity` WRITE;
/*!40000 ALTER TABLE `profanity` DISABLE KEYS */;
INSERT INTO `profanity` VALUES ('$#!+',NULL),('$1ut',NULL),('$h1t',NULL),('$hit',NULL),('$lut',NULL),('\'ho',NULL),('\'hobag',NULL),('a$$',NULL),('anal',NULL),('anus',NULL),('ass',NULL),('assmunch',NULL),('b1tch',NULL),('ballsack',NULL),('bastard',NULL),('beaner',NULL),('beastiality',NULL),('biatch',NULL),('beeyotch',NULL),('bitch',NULL),('bitchy',NULL),('blow job',NULL),('blow me',NULL),('blowjob',NULL),('second','dmatuf'),('hours','dmatuf'),('bollok',NULL),('boner',NULL),('boob',NULL),('bugger',NULL),('buttplug',NULL),('c-0-c-k',NULL),('c-o-c-k',NULL),('c-u-n-t',NULL),('c.0.c.k',NULL),('c.o.c.k.',NULL),('c.u.n.t',NULL),('jackoff',NULL),('jackhole',NULL),('j3rk0ff',NULL),('homo',NULL),('hom0',NULL),('hobag',NULL),('hell',NULL),('h0mo',NULL),('h0m0',NULL),('goddamn',NULL),('goddammit',NULL),('godamnit',NULL),('god damn',NULL),('ghey',NULL),('ghay',NULL),('gfy',NULL),('gay',NULL),('fudgepacker',NULL),('fudge packer',NULL),('fuckwad',NULL),('fucktard',NULL),('fuckoff',NULL),('fucker',NULL),('fuck-tard',NULL),('fuck off',NULL),('fuck',NULL),('fellatio',NULL),('fellate',NULL),('felching',NULL),('felcher',NULL),('felch',NULL),('fartknocker',NULL),('fannybandit',NULL),('fanny bandit',NULL),('faggot',NULL),('fagg',NULL),('fag',NULL),('f.u.c.k',NULL),('f-u-c-k',NULL),('dyke',NULL),('douchebag',NULL),('douche',NULL),('douch3',NULL),('doosh',NULL),('dildo',NULL),('dike',NULL),('dick',NULL),('damnit',NULL),('damn',NULL),('dammit',NULL),('d1ldo',NULL),('d1ld0',NULL),('d1ck',NULL),('d0uche',NULL),('d0uch3',NULL),('cunt',NULL),('cumstain',NULL),('cum',NULL),('crap',NULL),('coon',NULL),('cock',NULL),('clitoris',NULL),('clit',NULL),('cl1t',NULL),('cawk',NULL),('c0ck',NULL),('jerk0ff',NULL),('jerkoff',NULL),('jizz',NULL),('knob end',NULL),('knobend',NULL),('labia',NULL),('moolie',NULL),('muff',NULL),('nigga',NULL),('nigger',NULL),('p.u.s.s.y.',NULL),('penis',NULL),('piss',NULL),('piss-off',NULL),('pissoff',NULL),('prick',NULL),('pube',NULL),('pussy',NULL),('queer',NULL),('s hit',NULL),('s-h-1-t',NULL),('s-h-i-t',NULL),('s.h.i.t.',NULL),('scrotum',NULL),('sex',NULL),('sh1t',NULL),('shit',NULL),('slut',NULL),('smegma',NULL),('t1t',NULL),('terd',NULL),('tit',NULL),('tits',NULL),('titties',NULL),('minute','dmatuf'),('vag',NULL),('vagina',NULL),('wank',NULL),('wetback',NULL),('whore',NULL),('whoreface',NULL),('f*ck',NULL),('sh*t',NULL),('pu$$y',NULL),('p*ssy',NULL),('diligaf',NULL),('wtf',NULL),('stfu',NULL),('fu*ck',NULL),('fack',NULL),('shite',NULL),('fxck',NULL),('sh!t',NULL),('@sshole',NULL),('assh0le',NULL),('assho!e',NULL),('a$$hole',NULL),('a$$h0le',NULL),('a$$h0!e',NULL),('a$$h01e',NULL),('assho1e',NULL),('wh0re',NULL),('f@g',NULL),('f@gg0t',NULL),('f@ggot',NULL),('motherf*cker',NULL),('mofo',NULL),('cuntlicker',NULL),('cuntface',NULL),('dickbag',NULL),('fucking',NULL),('jizz bag',NULL),('cockknocker',NULL),('beatch',NULL),('fucknut',NULL),('nucking futs',NULL),('mams',NULL),('carpet muncher',NULL),('ass munch',NULL),('ass hat',NULL),('cunny',NULL),('clitty',NULL),('fuck wad',NULL),('kike',NULL),('spic',NULL),('time','dmatuf'),('chink',NULL),('wet back',NULL),('mother humper',NULL),('feltch',NULL),('feltcher',NULL),('fvck',NULL),('ahole',NULL),('nads',NULL),('spick',NULL),('douchey',NULL),('bullturds',NULL),('gonads',NULL),('butt',NULL),('s-o-b',NULL),('spunk',NULL),('he11',NULL),('jizm',NULL),('jism',NULL),('bukkake',NULL),('shiz',NULL),('wigger',NULL),('gook',NULL),('ritard',NULL),('reetard',NULL),('masterbate',NULL),('masturbate',NULL),('goatse',NULL),('masterbating',NULL),('masturbating',NULL),('hitler',NULL),('nazi',NULL),('tubgirl',NULL),('gtfo',NULL),('foad',NULL),('r-tard',NULL),('rtard',NULL),('hoor',NULL),('g-spot',NULL),('gspot',NULL),('vulva',NULL),('assmaster',NULL),('viagra',NULL),('phuck',NULL),('frack',NULL),('fuckwit',NULL),('assbang',NULL),('assbanged',NULL),('assbangs',NULL),('asshole',NULL),('assholes',NULL),('asswipe',NULL),('asswipes',NULL),('bastards',NULL),('bitched',NULL),('bitches',NULL),('blow jobs',NULL),('boners',NULL),('bullshit',NULL),('bullshits',NULL),('bullshitted',NULL),('cameltoe',NULL),('camel toe',NULL),('camel toes',NULL),('chinc',NULL),('chincs',NULL),('chode',NULL),('chodes',NULL),('clits',NULL),('cocks',NULL),('coons',NULL),('cumming',NULL),('cunts',NULL),('dickhead',NULL),('dickheads',NULL),('doggie-style',NULL),('dildos',NULL),('douchebags',NULL),('dumass',NULL),('dumb ass',NULL),('dumbasses',NULL),('dykes',NULL),('faggit',NULL),('fags',NULL),('fucked',NULL),('fuckface',NULL),('fucks',NULL),('gooks',NULL),('humped',NULL),('humping',NULL),('jackass',NULL),('jap',NULL),('japs',NULL),('jerk off',NULL),('jizzed',NULL),('kikes',NULL),('kooch',NULL),('kooches',NULL),('kootch',NULL),('mother fucker',NULL),('mother fuckers',NULL),('motherfucking',NULL),('niggah',NULL),('niggas',NULL),('niggers',NULL),('porch monkey',NULL),('porch monkeys',NULL),('pussies',NULL),('queers',NULL),('rim job',NULL),('rim jobs',NULL),('sand nigger',NULL),('sand niggers',NULL),('s0b',NULL),('shitface',NULL),('shithead',NULL),('shits',NULL),('shitted',NULL),('s.o.b.',NULL),('spik',NULL),('spiks',NULL),('minutes','dmatuf'),('whack off',NULL),('whores',NULL),('zoophile',NULL),('m-fucking',NULL),('mthrfucking',NULL),('muthrfucking',NULL),('mutherfucking',NULL),('mutherfucker',NULL),('mtherfucker',NULL),('mthrfucker',NULL),('mthrf*cker',NULL),('whorehopper',NULL),('maternal copulator',NULL),('whoralicious',NULL),('whorealicious',NULL),('hand job',NULL),('aeolus',NULL),('analprobe',NULL),('areola',NULL),('areole',NULL),('aryan',NULL),('arian',NULL),('asses',NULL),('assfuck',NULL),('azazel',NULL),('baal',NULL),('bang',NULL),('banger',NULL),('barf',NULL),('bawdy',NULL),('beardedclam',NULL),('beater',NULL),('beaver',NULL),('beer',NULL),('bigtits',NULL),('bimbo',NULL),('blew',NULL),('blowjobs',NULL),('seconds','dmatuf'),('boink',NULL),('boned',NULL),('bong',NULL),('boobies',NULL),('boobs',NULL),('booby',NULL),('bookie',NULL),('booky',NULL),('booty',NULL),('booze',NULL),('boozer',NULL),('boozy',NULL),('bosom',NULL),('bosomy',NULL),('bowel',NULL),('bowels',NULL),('bra',NULL),('brassiere',NULL),('bung',NULL),('bush',NULL),('buttfuck',NULL),('cocaine',NULL),('kinky',NULL),('klan',NULL),('panties',NULL),('pedophile',NULL),('pedophilia',NULL),('pedophiliac',NULL),('punkass',NULL),('queaf',NULL),('rape',NULL),('scantily',NULL),('essohbee',NULL),('shithouse',NULL),('smut',NULL),('doggie style',NULL),('anorexia',NULL),('bulimia',NULL),('bulimiic',NULL),('burp',NULL),('busty',NULL),('buttfucker',NULL),('caca',NULL),('cahone',NULL),('carnal',NULL),('carpetmuncher',NULL),('cervix',NULL),('climax',NULL),('cocain',NULL),('cocksucker',NULL),('coital',NULL),('coke',NULL),('commie',NULL),('condom',NULL),('corpse',NULL),('coven',NULL),('crack',NULL),('crackwhore',NULL),('crappy',NULL),('cuervo',NULL),('cummin',NULL),('cumshot',NULL),('cumshots',NULL),('cunnilingus',NULL),('dago',NULL),('dagos',NULL),('damned',NULL),('dick-ish',NULL),('dickish',NULL),('dickweed',NULL),('anorexic',NULL),('prostitute',NULL),('marijuana',NULL),('pcp',NULL),('diddle',NULL),('dawgie-style',NULL),('dimwit',NULL),('doofus',NULL),('dopey',NULL),('drunk',NULL),('ejaculate',NULL),('enlargement',NULL),('erect',NULL),('erotic',NULL),('exotic',NULL),('extacy',NULL),('extasy',NULL),('faerie',NULL),('faery',NULL),('fagged',NULL),('fagot',NULL),('fairy',NULL),('floozy',NULL),('fondle',NULL),('foobar',NULL),('foreskin',NULL),('frigg',NULL),('frigga',NULL),('fubar',NULL),('fuckup',NULL),('ganja',NULL),('gays',NULL),('glans',NULL),('godamn',NULL),('goddam',NULL),('goldenshower',NULL),('gonad',NULL),('handjob',NULL),('hebe',NULL),('heroin',NULL),('herpes',NULL),('hijack',NULL),('hiv',NULL),('homey',NULL),('honky',NULL),('hookah',NULL),('hooker',NULL),('hootch',NULL),('hooter',NULL),('hooters',NULL),('hump',NULL),('hussy',NULL),('hymen',NULL),('inbred',NULL),('incest',NULL),('injun',NULL),('jerked',NULL),('jiz',NULL),('horny',NULL),('junkie',NULL),('junky',NULL),('kkk',NULL),('kraut',NULL),('kyke',NULL),('lech',NULL),('leper',NULL),('lesbians',NULL),('lesbos',NULL),('lez',NULL),('lezbian',NULL),('lezbians',NULL),('lezbo',NULL),('lezbos',NULL),('lezzie',NULL),('lezzies',NULL),('lezzy',NULL),('lube',NULL),('massa',NULL),('masterbation',NULL),('masturbation',NULL),('maxi',NULL),('menses',NULL),('menstruate',NULL),('menstruation',NULL),('meth',NULL),('molest',NULL),('motherfucka',NULL),('motherfucker',NULL),('murder',NULL),('muthafucker',NULL),('nad',NULL),('naked',NULL),('napalm',NULL),('nappy',NULL),('nazism',NULL),('negro',NULL),('niggle',NULL),('ninny',NULL),('nipple',NULL),('nooky',NULL),('nympho',NULL),('opiate',NULL),('opium',NULL),('oral',NULL),('orally',NULL),('orgasm',NULL),('orgies',NULL),('orgy',NULL),('ovary',NULL),('ovum',NULL),('ovums',NULL),('paddy',NULL),('pantie',NULL),('panty',NULL),('pastie',NULL),('pasty',NULL),('pecker',NULL),('pedo',NULL),('pee',NULL),('peepee',NULL),('penetrate',NULL),('penetration',NULL),('penial',NULL),('penile',NULL),('perversion',NULL),('peyote',NULL),('phalli',NULL),('phallic',NULL),('pillowbiter',NULL),('pimp',NULL),('pinko',NULL),('pissed',NULL),('pms',NULL),('polack',NULL),('porn',NULL),('porno',NULL),('pornography',NULL),('prig',NULL),('pubic',NULL),('pubis',NULL),('punky',NULL),('puss',NULL),('queef',NULL),('quicky',NULL),('racist',NULL),('racy',NULL),('raped',NULL),('raper',NULL),('rapist',NULL),('rectal',NULL),('rectum',NULL),('rectus',NULL),('reefer',NULL),('reich',NULL),('revue',NULL),('risque',NULL),('rum',NULL),('rump',NULL),('sadism',NULL),('sadist',NULL),('satan',NULL),('scag',NULL),('schizo',NULL),('scrog',NULL),('scrot',NULL),('scrote',NULL),('scrud',NULL),('scum',NULL),('seaman',NULL),('seamen',NULL),('semen',NULL),('sex_story',NULL),('sexual',NULL),('shithole',NULL),('shitter',NULL),('shitty',NULL),('s*o*b',NULL),('skag',NULL),('slave',NULL),('sleaze',NULL),('sleazy',NULL),('sluts',NULL),('smutty',NULL),('sniper',NULL),('snuff',NULL),('sodom',NULL),('souse',NULL),('soused',NULL),('sperm',NULL),('spooge',NULL),('stab',NULL),('steamy',NULL),('stiffy',NULL),('stoned',NULL),('strip',NULL),('stroke',NULL),('whacking off',NULL),('sucking',NULL),('tampon',NULL),('tawdry',NULL),('teat',NULL),('teste',NULL),('testee',NULL),('testes',NULL),('testis',NULL),('thrust',NULL),('thug',NULL),('tinkle',NULL),('titfuck',NULL),('titi',NULL),('titty',NULL),('whacked off',NULL),('toke',NULL),('tramp',NULL),('millions','dmatuf'),('undies',NULL),('unwed',NULL),('urinal',NULL),('urine',NULL),('uterus',NULL),('uzi',NULL),('valium',NULL),('virgin',NULL),('vixen',NULL),('vodka',NULL),('voyeur',NULL),('vulgar',NULL),('wad',NULL),('wazoo',NULL),('weed',NULL),('srat','dmatuf'),('wench',NULL),('whitey',NULL),('whored',NULL),('whorehouse',NULL),('whoring',NULL),('x-rated',NULL),('xxx',NULL),('b@lls',NULL),('frat','dmatuf'),('sumofabiatch',NULL),('doggy-style',NULL),('doggy style',NULL),('wang',NULL),('dong',NULL),('d0ng',NULL),('w@ng',NULL),('wh0reface',NULL),('wh0ref@ce',NULL),('wh0r3f@ce',NULL),('tittyfuck',NULL),('tittyfucker',NULL),('tittiefucker',NULL),('cockholster',NULL),('cockblock',NULL),('gai',NULL),('gey',NULL),('faig',NULL),('faigt',NULL),('a55',NULL),('a55hole',NULL),('gae',NULL),('corksucker',NULL),('rumprammer',NULL),('slutdumper',NULL),('niggaz',NULL),('muthafuckaz',NULL),('gigolo',NULL),('pussypounder',NULL),('herp',NULL),('herpy',NULL),('million','dmatuf'),('gender dysphoria',NULL),('orgasmic',NULL),('cunilingus',NULL),('anilingus',NULL),('dickdipper',NULL),('dickwhipper',NULL),('dicksipper',NULL),('dickripper',NULL),('dickflipper',NULL),('dickzipper',NULL),('homoey',NULL),('queero',NULL),('freex',NULL),('cunthunter',NULL),('shamedame',NULL),('slutkiss',NULL),('shiteater',NULL),('slut devil',NULL),('fuckass',NULL),('fucka$$',NULL),('clitorus',NULL),('assfucker',NULL),('dillweed',NULL),('cracker',NULL),('teabagging',NULL),('shitt',NULL),('azz',NULL),('fuk',NULL),('fucknugget',NULL),('cuntlick',NULL),('g@y',NULL),('@ss',NULL),('beotch',NULL),('niggerfaggot',NULL),('cumbucket','wiatt'),('cuntnugget',NULL),('cuntmonkey',NULL),('jizzbomb',NULL),('hand jobs',NULL),('cockmuncher',NULL),('sideboob',NULL),('niggertits',NULL),('pussyfaggot',NULL),('midgetcricket','mitchell'),('buttslut','mitchell'),('queermo','mitchell'),('niggerlover','tillis'),('blumpkin','tillis'),('cooch','tillis'),('fuzz box','tillis'),('cum dumpster','tillis'),('cum guzzler','tillis'),('squirter','tillis'),('cum nugget','mitchell'),('faggot assatosis','mitchell'),('dicklick','mitchell'),('bitchfaggot','wiatt'),('s1ut','wiatt'),('naggertits','staubly'),('wanker','wiatt'),('pigfucker','mitchell'),('asshat','scherff'),('fuckery','mitchell'),('penis wrinkle','mitchell'),('fuckboi','mitchell'),('ass face','mitchell'),('dick sauce','mitchell'),('cuntmuffin','bell'),('cumbubble','scherff'),('dicktickler','scherff'),('hamplanet','bell'),('tittiesprinkles','bell'),('sugartits','bell'),('fuckthekids',NULL),('nutblower','bell'),('figgernaggot','bell'),('fetusfondler','bell'),('retardwad','bell'),('faghag','mitchell'),('fagalicious','mitchell'),('cumguzzler','mitchell'),('bukkake whore','mitchell'),('circle jerk','mitchell'),('mushroomstamp','mitchell'),('liquor','tillis'),('hour','dmatuf'),('gooch','mitchell'),('teabag','mitchell'),('faggatron','mitchell'),('poop','tillis'),('doo doo','tillis'),('doo-doo','tillis'),('jewfus','mitchell'),('sitting','dmatuf'),('tired','dmatuf'),('just dance','dmatuf'),('omfg',NULL),('condoms','scherff'),('dingleberry','bell');
/*!40000 ALTER TABLE `profanity` ENABLE KEYS */;
UNLOCK TABLES;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `profanity_insert` BEFORE INSERT ON `profanity` FOR EACH ROW set NEW.word = lower(NEW.word) */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `profanity_update` BEFORE UPDATE ON `profanity` FOR EACH ROW set NEW.word = lower(NEW.word) */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `settings` (
  `id` enum('') DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `display` tinyint(1) DEFAULT NULL,
  `profanity` tinyint(1) DEFAULT NULL,
  `question` text,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('',1,1,1,'What\'s your favorite theme hour so far?');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tweets` (
  `id` varchar(50) NOT NULL DEFAULT '',
  `message` text,
  `img` text,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `pending` tinyint(1) DEFAULT '0',
  `retweets` int(11) DEFAULT '0',
  `approved` tinyint(1) DEFAULT '0',
  `displayed` tinyint(1) DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `banned` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_reference` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;

/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `update_retweets` BEFORE UPDATE ON `tweets` FOR EACH ROW BEGIN
    IF (NEW.retweets < OLD.retweets) THEN
    SET NEW.retweets = OLD.retweets;
    END IF;
END */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL,
  `image` text,
  `username` varchar(50) DEFAULT NULL,
  `banned_tweets` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `users_insert` BEFORE INSERT ON `users` FOR EACH ROW set NEW.username = lower(NEW.username) */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `users_update` BEFORE UPDATE ON `users` FOR EACH ROW set NEW.username = lower(NEW.username) */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Table structure for table `whitelist`
--

DROP TABLE IF EXISTS `whitelist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `whitelist` (
  `username` varchar(50) DEFAULT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `whitelist`
--

LOCK TABLES `whitelist` WRITE;
/*!40000 ALTER TABLE `whitelist` DISABLE KEYS */;
INSERT INTO `whitelist` VALUES ('angelanightly'),('cmn_zac'),('floridadm'),('g_chappell'),('j_sanchez_13'),('katieflawlesss'),('madihager'),('mattgerstman'),('scapone23'),('smacnturf'),('sydspratt'),('_nicolemartinez');
/*!40000 ALTER TABLE `whitelist` ENABLE KEYS */;
UNLOCK TABLES;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `whitelist_insert` BEFORE INSERT ON `whitelist` FOR EACH ROW set NEW.username = lower(NEW.username) */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dmapplications`@`208.113.128.0/255.255.128.0` */ /*!50003 TRIGGER `whitelist_update` BEFORE UPDATE ON `whitelist` FOR EACH ROW set NEW.username = lower(NEW.username) */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;

--
-- Dumping routines for database 'tweettwoscreens'
--
DELIMITER ;;
DELIMITER ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-30  5:13:17
