<?php

//require __DIR__ . "/vendor/autoload.php";
//require __DIR__ . "/.conf.php";

//use Abraham\TwitterOAuth\TwitterOAuth;

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
	"edwyplenel"
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
		"label" => "des Panama papers",
		"hashtags" => array(
			"panamapapers",
			"transparence",
			"fraude"
		)
	),
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
		"label" => "de la Corée du Nord",
		"hashtags" => array(
			"northkorea"
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
	"ppl2017"
];


mt_srand();




$punct_list = [
    ".", ".", " !", "...", ".", "..."
];


$politic = $influent_accounts_politics[mt_rand(0, count($influent_accounts_politics) -1)];
$journalist = $influent_accounts_news[mt_rand(0, count($influent_accounts_news) -1)];
$city = $cities[mt_rand(0, count($cities) -1)];

$subject = $controversy_subjects[mt_rand(0, count($controversy_subjects) -1)];
$subject_label = $subject["label"];
$hashtag = $subject["hashtags"][mt_rand(0, count($subject["hashtags"]) -1)];

$punct = $punct_list[mt_rand(0, count($punct_list) -1)];

//    $e = $buzz_words[mt_rand(0, count($buzz_words) -1)];
//    $f = $buzz_words[mt_rand(0, count($buzz_words) -1)];

$phrases = [
	"Belle rencontre avec @$politic au sujet $subject_label$punct #$hashtag",
	"Les positions de @$politic pour ce qui est $subject_label m'inquiètent$punct #$hashtag",
	"La dernière déclaration de @$politic à propos $subject_label n'est pas une bonne nouvelle$punct",
	"On n'avance vraiment pas au sujet $subject_label$punct, n'est-ce-pas @$journalist ?",
	"Il faudrait que @$journalist aborde un peu plus le thème $subject_label$punct #$hashtag",
	"Rendez-vous demain à $city avec @$journalist pour parler $subject_label$punct",
];


$res = $phrases[mt_rand(0, count($phrases) -1)];

echo $res;


/*$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$content = $connection->post("statuses/update", ['status' => $res]);*/
