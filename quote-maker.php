<?php
require __DIR__ . "/data/quotable-people.php";

global $quotable_people;

$punct_list = [
    ".", ".", ".", ".", ".", " !", " !", "..."
];
$punct = $punct_list[mt_rand(0, count($punct_list) -1)];
$punct2 = $punct_list[mt_rand(0, count($punct_list) -1)];

$situation_list = [
	"en allant se coucher",
	"en allant se promener",
	"face à l'océan",
	"avec sa famille",
	"sous sa douche",
	"dans une soirée mondaine",
	"au réveil",
	"dans de bien pires situations",
	"perdu dans la foule",
	"un verre à la main",
];
$situation = $situation_list[mt_rand(0, count($situation_list) -1)];

$say_verb = [
	"dit",
	"crié",
	"dit",
	"dit",
	"déclaré",
];
$say = $say_verb[mt_rand(0, count($say_verb) -1)];

$subjects_list = [
	"le coeur",
	"l'oeil",
	"le fou",
	"le soleil",
	"chaque étoile",
	"la lune",
	"la mer",
	"l'océan",
	"chaque rue",
	"chaque arbre",
	"le peuple",
];
$subject = $subjects_list[mt_rand(0, count($subjects_list) -1)];

$verb_list = [
	"montre les",
	"mène aux",
	"guide les",
	"apporte les",
	"sourit aux",
	"désigne les",
	"dévoile les",
];
$verb = $verb_list[mt_rand(0, count($verb_list) -1)];

$object_list = [
	"chemins les plus simples",
	"audacieux",
	"amis les plus fidèles",
	"visions les plus belles",
	"plus horribles attitudes",
	"plus belles avancées",
	"belles idées",
	"idées révolutionnaires",
	"marchands de mort",
	"ambitions les plus absurdes",
];
$object = $object_list[mt_rand(0, count($object_list) -1)];



$people = $quotable_people[mt_rand(0, count($quotable_people) -1)];
$quotable_sentences = [
	"C'est ce qu'aurait $say $people$punct",
	"$people doit se retourner dans sa tombe en vous lisant$punct",
	"$people serait fier de vous$punct",
	"$people aurait honte de vous$punct",
	"Je m'autorise à penser que $people se reconnaitrait dans vos paroles$punct",
	
	"Comme l'aurait $say $people $situation, $subject $verb $object$punct",
	"Je me permets de citer $people : $subject $verb $object$punct",
	"Hum... $subject, disait $people, $verb $object$punct",
	"Euh... N'oubliez pas $people, $subject $verb $object$punct",
	
//	"$people $situation$punct Quand j'y pense$punct2",
	"Vous arrive-t-il de penser à ce qu'aurait $say $people $situation ?",
	"Cela me laisse sans voix, comme $people $situation$punct",
	"Vous vous comportez tel $people $situation$punct",
];
global $answer_sentence;
$answer_sentence = $quotable_sentences[mt_rand(0, count($quotable_sentences) -1)];
echo $answer_sentence;