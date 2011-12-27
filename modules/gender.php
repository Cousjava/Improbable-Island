<?php

function gender_getmoduleinfo(){
	$info = array(
		"name"=>"Gender Prefs",
		"author"=>"Cousjava",
		"version"=>"1.0 27-12-2011",
		"category"=>"General",
		"download"=>"https://github.com/Cousjava/Improbable-Island",
		"prefs"=>array(
			"Gender Prefs,title",
			"user_Gender"=>"The gender noun i.e. male,text|person",
			"user_Subjective"=>"The subjective pronoun i.e. he or she,text|they",
			"user_Objective"=>"The objective pronoun i.e. him or her,text|them",
			"user_Reflexive"=>"The reflexive pronoun i.e. himself,text|themself",
			"user_Possessive_Pronoun"=>"The posessive pronoun i.e. his or hers,text|theirs",
			"user_Posessive_Determiner"=>"The possessive dererminer i.e. his or her,text|their",
		)
	);
	return $info;
}

function gender_install(){
	module_addhook("moderate");
	return true;
}

function gender_uninstall(){
	return true;
}

function gender_dohook($hookname,$args){
	global $session;
	switch($hookname){
		case "moderate":
			$args['gender'] = "Gender Settings";
		break;
	}
	return $args;
}

function gender_run(){
}
?>
