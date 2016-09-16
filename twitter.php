<?php

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
		"label" => "de la Corée du Nord",
		"hashtags" => array(
			"northkorea"
		)
	),
	array(
		"label" => "du nucléaire iranien",
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
		"label" => "du réchauffement climatique",
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
		"label" => "du numérique",
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
		"label" => "du nucléaire",
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
		"label" => "de la sécurité",
		"hashtags" => array(
			"securite",
			"terrorisme",
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
	"",
	"",
	" #ppl2017"
];


mt_srand();




$punct_list = [
    ".", ".", ".", ".", ".", " !", " !", "...", "..."
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
	"Les positions de @$politic pour ce qui est $subject_label m'inquiètent$punct #$hashtag",
	"La dernière déclaration de @$politic à propos $subject_label n'est pas une bonne nouvelle$punct",
	"Je tiens à saluer le travail de @$politic à propos $subject_label$punct",
	"Je suis assez surpris des positions de @$politic en faveur $subject_label$punct",
	"Il serait bon de ne pas bafouer les valeurs de la république, @$politic$punct",
	"Ce qui intéresse les français, c'est de clarifier les avancées à propos $subject_label, @$politic$punct",
	"Le gouvernement n'a pas assez fait d'effort en faveur $subject_label, n'est-ce-pas @$politic ?",
	
	"On n'avance vraiment pas au sujet $subject_label, n'est-ce-pas @$journalist ?",
	"Il faudrait que @$journalist aborde un peu plus le thème $subject_label$punct #$hashtag",
	"Nos concitoyens seraient intéressés pour en savoir plus sur le thème $subject_label, @$journalist$punct #$hashtag",
	"Rendez-vous demain à $city avec @$journalist pour parler $subject_label$punct$own_hashtag",
	
	"J'attends toujours l'invitation de @$show pour pouvoir exposer mon programme aux français$punct$own_hashtag",
	"Sur @$show, on ne parle toujours pas des vrais sujets, par exemple $subject_label$punct",
	"Très honoré d'intervenir demain sur @$show pour parler $subject_label$punct$own_hashtag",
	
	"Retrouvez mon interview demain dans @$newspaper$punct J'y parlerai $subject_label$punct$own_hashtag",
	"Quand @$newspaper m'invitera, nous discuterons enfin des vrais sujets$punct Par exemple $subject_label$punct #$hashtag",
	"Merci à @$newspaper pour avoir repris mes propos avec précision$punct$own_hashtag",
	
	"On s'attarde trop au sujet $controversy_subject_label$punct Et si on parlait $subject_label ? #$controversy_hashtag #$hashtag",
	"Tous ces débats autour $controversy_subject_label ne mènent à rien$punct #$controversy_hashtag",
	"Les esprits s'échauffent vite quand on aborde la question $controversy_subject_label$punct #$controversy_hashtag",
	
	"Cette semaine, je serai à $city à la rencontre des français pour parler $subject_label$punct$own_hashtag",
	"Vous connaissez mes opinions, je ne vais pas polémiquer au sujet $subject_label$punct #$hashtag$own_hashtag",
	"Je suis fier d'annoncer un comité de réflexion à propos $subject_label$punct #$hashtag$own_hashtag",
	"Notre pays mérite qu'on s'engage, que l'on prenne des risques$punct$own_hashtag",
	"Innovation, recherche, c'est cela qui est nécessaire quand on aborde la question $subject_label$punct #$hashtag",
	"Pensée à tous les acteurs réunis autour de la question $subject_label$punct Il est temps que les choses bougent$punct #$hashtag",
	"Restons mobilisés au sujet $subject_label$punct Prenons le temps d'en parler$punct$own_hashtag",
	"Un objectif : garder le cap sur nos valeurs au sujet $subject_label$punct #$hashtag$own_hashtag",
	"Là où certains élus refusent de s'engager, je serai intransigeant à propos $subject_label$punct$own_hashtag",
	
];


$res = $phrases[mt_rand(0, count($phrases) -1)];

echo $res;

$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$content = $connection->post("statuses/update", ['status' => utf8_encode($res)]);