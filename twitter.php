<?php

$days_list = [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ];
$current_date = new DateTime( );
$current_date->setTimezone(new DateTimeZone('Europe/Paris'));
$current_day = $current_date->format('w');
$current_hour = $current_date->format('H');
$day_str = $days_list[$current_day];

//Do not post before 6AM
if ( $current_hour < 6 ) {
	exit();
}

//Do not post everytime
$random = rand(1, 4);
if ($random == 4) {
	exit();
}



require __DIR__ . "/.conf.php";
require __DIR__ . "/twitter/Config.php";
require __DIR__ . "/twitter/Response.php";
require __DIR__ . "/twitter/Consumer.php";
require __DIR__ . "/twitter/Request.php";
require __DIR__ . "/twitter/Util/JsonDecoder.php";
require __DIR__ . "/twitter/Util.php";
require __DIR__ . "/twitter/Token.php";
require __DIR__ . "/twitter/SignatureMethod.php";
require __DIR__ . "/twitter/HmacSha1.php";
require __DIR__ . "/twitter/TwitterOAuthException.php";
require __DIR__ . "/twitter/TwitterOAuth.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$influent_accounts_politics = [
	"RoyalSegolene",
	"bayrou",
	"JLMelenchon",
	"FrancoisFillon",
	"EmmanuelMacron",
	"nk_m",
	"MLP_officiel",
	"NicolasSarkozy",
	"Marion_M_Le_Pen",
	"fhollande",
	"manuelvalls",
	"SLeFoll",
	"BCazeneuve",
	"SLeFoll",
	"najatvb",
	"ChTaubira",
	"JY_LeDrian",
	"MarisolTouraine",
];

$influent_accounts_news = [
	"lauhaim",
	"laurentbazin",
	"JeudyBruno",
	"jcartillier",
	"lofejoma",
	"PhilippeCorbe",
	"aslapix",
	"GTabard",
	"jmaphatie",
	"fabricearfi",
	"DanielRiolo",
	"jbcadier",
	"ThomasSotto",
	"FCarbonne",
	"ericbrunet",
	"Bruce_Toussaint",
	"NathalieSchuck",
	"EGuedel",
	"Fanny_Agostini",
	"edwyplenel"
];

$influent_shows = [
	"JJBourdin_RMC",
	"franceinter",
	"Europe1",
	"RTLFrance",
	"BFMPolitique",
	"itele",
	"Qofficiel",
];

$influent_timedshows = [
	"Lundi" => array(
		"07" => "BourdinDirect",
		"08" => "le79Inter",
		"11" => "GGRMC cc @GG_RMC",
		"13" => "GGRMC cc @GG_RMC",
		"18" => "jourdanslemonde cc @ndemorand",
		"19" => "jourdanslemonde cc @ndemorand",
		"21" => "GalziMinuit cc @OlivierGalzi",
	),
	"Mardi" => array(
		"07" => "le79Inter",
		"08" => "RTLMatin",
		"11" => "GGRMC cc @GG_RMC",
		"12" => "GGRMC cc @GG_RMC",
		"18" => "jourdanslemonde cc @ndemorand",
		"19" => "jourdanslemonde cc @ndemorand",
		"22" => "GalziMinuit cc @OlivierGalzi",
	),
	"Mercredi" => array(
		"07" => "E1matin",
		"08" => "le79Inter",
		"10" => "GGRMC cc @GG_RMC",
		"12" => "GGRMC cc @GG_RMC",
		"18" => "jourdanslemonde cc @ndemorand",
		"19" => "jourdanslemonde cc @ndemorand",
		"23" => "GalziMinuit cc @OlivierGalzi",
	),
	"Jeudi" => array(
		"07" => "RTLMatin",
		"08" => "BourdinDirect",
		"09" => "BourdinDirect cc @JJBourdin_RMC",
		"11" => "GGRMC cc @GG_RMC",
		"12" => "CPMCB",
		"18" => "jourdanslemonde cc @ndemorand",
		"19" => "jourdanslemonde cc @ndemorand",
		"21" => "LEmissionPolitique",
		"22" => "LEmissionPolitique",
		"23" => "GalziMinuit cc @OlivierGalzi",
	),
	"Vendredi" => array(
		"07" => "BourdinDirect",
		"08" => "E1matin",
		"10" => "GGRMC cc @GG_RMC",
		"11" => "GGRMC cc @GG_RMC",
		"12" => "CPMCB",
	),
	"Samedi" => array(
		"23" => "ONPC"
	),
	"Dimanche" => array(
		"10" => "LeGrandRdv cc @JP_Elkabbach",
		"12" => "questionspol cc @ndemorand",
		"13" => "questionspol cc @ndemorand",
		"18" => "DimanchePol cc @AudreyPulvar",
		"19" => "DimanchePol cc @hbonduelle",
	)
];

$influent_newspaper = [
	"libe",
	"lemondefr",
	"Le_Figaro",
	"humanite_fr",
	"MarianneleMag",
	"lerepu",
	"presseocean",
	"20Minutes",
	"le_parisien",
];

$controversy_subjects = [
	array(
		"label" => "du burkini",
		"hashtags" => array(
			"burkini",
			"liberte"
		)
	),
	array(
		"label" => "de la Cor�e du Nord",
		"hashtags" => array(
			"northkorea"
		)
	),
	array(
		"label" => "du nucl�aire iranien",
		"hashtags" => array(
			"iran"
		)
	),
	array(
		"label" => "des Panama papers",
		"hashtags" => array(
			"panamapapers",
			"transparence",
			"fraude"
		)
	),
	array(
		"label" => "de l'euthanasie",
		"hashtags" => array(
			"euthanasie",
			"choix",
			"liberte"
		)
	),
	array(
		"label" => "du salaire des grands patrons",
		"hashtags" => array(
			"transparence",
		)
	),
	array(
		"label" => "de la d�p�nalisation du canabis",
		"hashtags" => array(
			"canabis",
		)
	),
];

$main_subjects = [
	array(
		"label" => "du Brexit",
		"hashtags" => array(
			"brexit"
		)
	),
	array(
		"label" => "de Monsanto",
		"hashtags" => array(
			"monsanto",
			"bayer"
		)
	),
	array(
		"label" => "du r�chauffement climatique",
		"hashtags" => array(
			"globalwarming",
			"ecologie",
			"green",
			"globalwarming",
		)
	),
	array(
		"label" => "de la finance",
		"hashtags" => array(
			"finance",
			"transparence",
		)
	),
	array(
		"label" => "de la Syrie",
		"hashtags" => array(
			"syrie",
		)
	),
	array(
		"label" => "du num�rique",
		"hashtags" => array(
			"digital",
			"numerique",
			"disruption",
		)
	),
	array(
		"label" => "de l'Europe",
		"hashtags" => array(
			"brexit",
			"europe",
			"ue",
		)
	),
	array(
		"label" => "du nucl�aire",
		"hashtags" => array(
			"energie",
			"nucleaire"
		)
	),
	array(
		"label" => "du Grand Paris",
		"hashtags" => array(
			"paris",
			"decentralisation",
		)
	),
	array(
		"label" => "de la s�curit�",
		"hashtags" => array(
			"securite",
			"terrorisme",
		)
	),
	array(
		"label" => "de l'�galit� hommes-femmes",
		"hashtags" => array(
			"egalite",
		)
	),
	array(
		"label" => "du cumul des mandats",
		"hashtags" => array(
			"transparence",
		)
	),
	array(
		"label" => "du ch�mage",
		"hashtags" => array(
			"chomage",
			"emploi",
		)
	),
	array(
		"label" => "de l'entreprenariat fran�ais",
		"hashtags" => array(
			"chomage",
			"emploi",
		)
	),
	array(
		"label" => "de la conqu�te de Mars",
		"hashtags" => array(
			"futur",
			"avenir",
			"recherche",
		)
	),
	array(
		"label" => "de l'�vasion fiscale",
		"hashtags" => array(
			"panamapapers",
			"transparence",
		)
	),
	array(
		"label" => "du pouvoir d'achat",
		"hashtags" => array(
			"emploi",
		)
	),
];

$cities = [
	"Paris",
	"Paris",
	"Paris",
	"Verdun",
	"Strasbourg",
	"Lyon",
	"Bordeaux",
	"Marseille",
];

$own_hashtags = [
	"",
	" #ppl2017"
];


mt_srand();




$punct_list = [
    ".", ".", ".", ".", ".", " !", " !", "..."
];


$politic = $influent_accounts_politics[mt_rand(0, count($influent_accounts_politics) -1)];
$journalist = $influent_accounts_news[mt_rand(0, count($influent_accounts_news) -1)];
$city = $cities[mt_rand(0, count($cities) -1)];
$show = $influent_shows[mt_rand(0, count($influent_shows) -1)];
$newspaper = $influent_newspaper[mt_rand(0, count($influent_newspaper) -1)];

$own_hashtag = $own_hashtags[mt_rand(0, count($own_hashtags) -1)];

$controversy_subject = $controversy_subjects[mt_rand(0, count($controversy_subjects) -1)];
$controversy_subject_label = $controversy_subject["label"];
$controversy_hashtag = $controversy_subject["hashtags"][mt_rand(0, count($controversy_subject["hashtags"]) -1)];

$subject = $main_subjects[mt_rand(0, count($main_subjects) -1)];
$subject_label = $subject["label"];
$hashtag = $subject["hashtags"][mt_rand(0, count($subject["hashtags"]) -1)];

$punct = $punct_list[mt_rand(0, count($punct_list) -1)];

$phrases = [
	"Belle rencontre avec @$politic au sujet $subject_label$punct #$hashtag",
	"Les positions de @$politic pour ce qui est $subject_label m'inqui�tent$punct #$hashtag",
	"La derni�re d�claration de @$politic � propos $subject_label n'est pas une bonne nouvelle$punct",
	"Je suis assez surpris des positions de @$politic en faveur $subject_label$punct",
	"Ce qui int�resse les fran�ais, c'est de clarifier les avanc�es � propos $subject_label, @$politic$punct",
	"Le gouvernement n'a pas assez fait d'effort en faveur $subject_label, n'est-ce-pas @$politic ?",
	
	"On n'avance vraiment pas au sujet $subject_label, n'est-ce-pas @$journalist ?",
	"Il faudrait que @$journalist aborde un peu plus le th�me $subject_label$punct #$hashtag",
	"Nos concitoyens seraient int�ress�s pour en savoir plus sur le th�me $subject_label, @$journalist$punct #$hashtag",
	"Rendez-vous demain � $city avec @$journalist pour parler $subject_label$punct$own_hashtag",
	
	"J'attends toujours l'invitation de @$show pour pouvoir exposer mon programme aux fran�ais$punct$own_hashtag",
	"Sur @$show, on ne parle toujours pas des vrais sujets, par exemple $subject_label$punct",
	"Tr�s honor� d'intervenir demain sur @$show pour parler $subject_label$punct$own_hashtag",
	
	"Retrouvez mon interview demain dans @$newspaper$punct J'y parlerai $subject_label$punct$own_hashtag",
	"Quand @$newspaper m'invitera, nous discuterons enfin des vrais sujets$punct Par exemple $subject_label$punct #$hashtag",
	"Merci � @$newspaper pour avoir repris mes propos avec pr�cision$punct$own_hashtag",
	
	"On s'attarde trop au sujet $controversy_subject_label$punct Et si on parlait $subject_label ? #$controversy_hashtag #$hashtag",
	"Tous ces d�bats autour $controversy_subject_label ne m�nent � rien$punct #$controversy_hashtag",
	"Les esprits s'�chauffent vite quand on aborde la question $controversy_subject_label$punct #$controversy_hashtag",
	
	"Cette semaine, je serai � $city � la rencontre des fran�ais pour parler $subject_label$punct$own_hashtag",
	"Vous connaissez mes opinions, je ne vais pas pol�miquer au sujet $subject_label$punct #$hashtag$own_hashtag",
	"Je suis fier d'annoncer un comit� de r�flexion � propos $subject_label$punct #$hashtag$own_hashtag",
	"Restons mobilis�s au sujet $subject_label$punct Prenons le temps d'en parler$punct$own_hashtag",
	"Un objectif : garder le cap sur nos valeurs au sujet $subject_label$punct #$hashtag$own_hashtag",
	"L� o� certains �lus refusent de s'engager, je serai intransigeant � propos $subject_label$punct$own_hashtag",
	"Il est �vident que le th�me $subject_label sera au coeur de ma campagne$punct$own_hashtag",
	"Nous ne pouvons plus �tre divis�s au sujet $subject_label$punct Il est temps de trouver des compromis$punct #$hashtag$own_hashtag",
	
];
$result_vague = $phrases[mt_rand(0, count($phrases) -1)];
$res = $result_vague;



//R�cup�ration de l'�mission qui a lieu � cette heure-l�
$result_direct = "";
if (isset($influent_timedshows[$day_str][$current_hour])) {
	
	$time_str = "ce midi";
	if ($current_hour < 12) {
		$time_str = "ce matin";
	}
	if ($current_hour > 17) {
		$time_str = "ce soir";
	}
	$hashtag_direct = $influent_timedshows[$day_str][$current_hour];
	$phrases_react_direct = [
		"Les d�bats sont anim�s $time_str$punct #$hashtag_direct $own_hashtag",
		"Attentif $time_str face aux discussions qui animent #$hashtag_direct$punct $own_hashtag",
		"A l'�coute $time_str des d�bats en direct sur #$hashtag_direct$punct $own_hashtag",
		
		"Pourquoi la France est-elle toujours divis�e sur ces sujets ? Il est temps de se rassembler$punct #$hashtag_direct $own_hashtag",
		"Il est temps d'arr�ter de gaspiller l'argent que nous n'avons plus$punct #$hashtag_direct $own_hashtag",
		"Arr�tons de bafouer les valeurs de la r�publique, prenons nos responsabilit�s$punct #$hashtag_direct $own_hashtag",
		
		"J'ai r�cemment �chang� au sujet $subject_label avec @$politic$punct #$hashtag_direct $own_hashtag",
		
		"J'aurais aim� que l'on parle un peu plus $subject_label$punct #$hashtag_direct #$hashtag$own_hashtag",
		"N'oublions pas les vrais sujets... Il serait bon d'aborder le sujet $subject_label$punct #$hashtag_direct $own_hashtag",
		"On entend assez peu d'avis � propos $subject_label$punct #$hashtag_direct #$hashtag$own_hashtag",
		"Innovation, recherche, c'est cela qui est n�cessaire quand on aborde la question $subject_label$punct #$hashtag_direct #$hashtag$own_hashtag",
		"Notre pays m�rite qu'on s'engage, que l'on prenne des risques$punct #$hashtag_direct$own_hashtag",
		"Pens�e � tous les acteurs r�unis autour de la question $subject_label$punct Il est temps que les choses bougent$punct #$hashtag_direct #$hashtag$own_hashtag",
		"Le gouvernement a encore beaucoup de travail � accomplir pour pouvoir parler $subject_label$punct #$hashtag_direct$own_hashtag",
	];
	$result_direct = $phrases_react_direct[mt_rand(0, count($phrases_react_direct) -1)];

}


//4 fois sur 5, on r�agit � l'�mission en direct
if ($result_direct != "") {
	$random = rand(1, 5);
	if ($random < 5) {
		$res = $result_direct;
	}
}


echo $res;

$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$content = $connection->post("statuses/update", ['status' => utf8_encode($res)]);