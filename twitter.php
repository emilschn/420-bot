<?php
$current_date = new DateTime( );
$current_date->setTimezone(new DateTimeZone('Europe/Paris'));
$current_hour = $current_date->format('H');

//Do not post before 6AM
if ( $current_hour < 6 ) { exit(); }

//Do not post everytime : 2 out of 5, for 2 different scripts
$random = rand(1, 5);
if ($random > 2) { exit(); }



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

require __DIR__ . "/data/cities.php";
require __DIR__ . "/data/politics.php";
require __DIR__ . "/data/journalists.php";
require __DIR__ . "/data/shows.php";
require __DIR__ . "/data/timed-shows.php";
require __DIR__ . "/data/newspapers.php";
require __DIR__ . "/data/subjects-controversy.php";
require __DIR__ . "/data/subjects-main.php";

global $influent_accounts_politics, $cities, $coordinates,
		$influent_accounts_news, $influent_newspaper,
		$influent_shows, $influent_timedshows,
		$controversy_subjects, $main_subjects;


$days_list = [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ];
$current_day = $current_date->format('w');
$day_str = $days_list[$current_day];
$own_hashtags = [ "", " #ppl2017" ];


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
	"Les positions de @$politic pour ce qui est $subject_label m'inquiètent$punct #$hashtag",
	"La dernière déclaration de @$politic à propos $subject_label n'est pas une bonne nouvelle$punct",
	"Je suis assez surpris des positions de @$politic en faveur $subject_label$punct",
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
	"Restons mobilisés au sujet $subject_label$punct Prenons le temps d'en parler$punct$own_hashtag",
	"Un objectif : garder le cap sur nos valeurs au sujet $subject_label$punct #$hashtag$own_hashtag",
	"Là où certains élus refusent de s'engager, je serai intransigeant à propos $subject_label$punct$own_hashtag",
	"Il est évident que le thème $subject_label sera au coeur de ma campagne$punct$own_hashtag",
	"Nous ne pouvons plus être divisés au sujet $subject_label$punct Il est temps de trouver des compromis$punct #$hashtag$own_hashtag",
	
];
$result_vague = $phrases[mt_rand(0, count($phrases) -1)];
$res = $result_vague;


//Tests if there is a show at the current time
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
		"Les débats sont animés $time_str$punct #$hashtag_direct $own_hashtag",
		"Attentif $time_str face aux discussions qui animent #$hashtag_direct$punct $own_hashtag",
		"A l'écoute $time_str des débats en direct sur #$hashtag_direct$punct $own_hashtag",
		
		"Pourquoi la France est-elle toujours divisée sur ces sujets ? Il est temps de se rassembler$punct #$hashtag_direct $own_hashtag",
		"Il est temps d'arrêter de gaspiller l'argent que nous n'avons plus$punct #$hashtag_direct $own_hashtag",
		"Arrêtons de bafouer les valeurs de la république, prenons nos responsabilités$punct #$hashtag_direct $own_hashtag",
		"Je suis effaré par la médiocrité des débats$punct #$hashtag_direct $own_hashtag",
		
		"J'ai récemment échangé au sujet $subject_label avec @$politic$punct #$hashtag_direct $own_hashtag",
		
		"J'aurais aimé que l'on parle un peu plus $subject_label$punct #$hashtag_direct #$hashtag$own_hashtag",
		"N'oublions pas les vrais sujets... Il serait bon d'aborder le sujet $subject_label$punct #$hashtag_direct $own_hashtag",
		"On entend assez peu d'avis à propos $subject_label$punct #$hashtag_direct #$hashtag$own_hashtag",
		"Innovation, recherche, c'est cela qui est nécessaire quand on aborde la question $subject_label$punct #$hashtag_direct #$hashtag$own_hashtag",
		"Notre pays mérite qu'on s'engage, que l'on prenne des risques$punct #$hashtag_direct$own_hashtag",
		"Pensée à tous les acteurs réunis autour de la question $subject_label$punct Il est temps que les choses bougent$punct #$hashtag_direct #$hashtag$own_hashtag",
		"Le gouvernement a encore beaucoup de travail à accomplir pour pouvoir parler $subject_label$punct #$hashtag_direct$own_hashtag",
	];
	$result_direct = $phrases_react_direct[mt_rand(0, count($phrases_react_direct) -1)];

}


$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

//There is a show
//4 times out of 5, react to the show
if ($result_direct != "") {
	$random = rand(1, 5);
	if ($random < 5) {
		$res = $result_direct;
	}

//There is no show
} else {
	
	//1 time out of 5, retweet a news
	$random = rand(1, 5);
	if ($random == 1) {
		$last_news_to_retweet_list = $connection->get("statuses/user_timeline", ['screen_name' => $newspaper, 'count' => 1]);
		$last_news_to_retweet = $last_news_to_retweet_list[0];
		
	//No retweet
	} else {
		
		//1 time out of 10, react to a trend close to a random town
		$random = rand(1, 15);
		if ($random == 1) {
			$city_coordinates = $coordinates[$city];
			$geoloc_list = $connection->get("trends/closest", ['lat' => $city_coordinates[0], 'long' => $city_coordinates[1]]);
			$woeid = $geoloc_list[0]->woeid;
			$closest_trends_list = $connection->get("trends/place", ['id' => $woeid]);
			$closest_trend = $closest_trends_list[0]->trends[0]->name;

			echo '<br /><br />';
			echo 'closest trend: ' . $closest_trend;
			$phrases_trends = [
				"Je viens d'arriver à $city et je ne peux pas croire que ce soit $closest_trend qui vous intéresse le plus$punct$own_hashtag",
				"Quelle tristesse de constater qu'à $city, le principal sujet reste $closest_trend$punct$own_hashtag",
				"La jeunesse de $city n'a l'air de s'intéresser qu'à $closest_trend, quel désarroi$punct$own_hashtag",
				"Moi aussi, il m'arrive de m'intéresser à $closest_trend, comme tous les français$punct$own_hashtag",
			];
			$res = $phrases_trends[mt_rand(0, count($phrases_trends) -1)];
		}
		
	}
}

if (isset($last_news_to_retweet)) {
	echo '<br /><br />';
	echo 'ID to retweet: ' .$last_news_to_retweet->id;
	$content = $connection->post("statuses/retweet/".$last_news_to_retweet->id);
	
} else {
	echo '<br /><br />';
	echo 'Phrase: ' .$res;
	$content = $connection->post("statuses/update", ['status' => utf8_encode($res)]);
}