<?php
define('LARY',['0'=>'rus','1'=>'eng','2'=>'ger']);
define('FORHTML',['0'=>'ru','1'=>'en','2'=>'de']);
//GET LANGUAGE
if (isset($_REQUEST['getlang'])){
	$usr_lang = $_REQUEST['getlang'];
	$langid = $_REQUEST['langid'];
	//
 	if (key_exists($langid,LARY)){
	include_once ("../cl/db_class.php");
    $li = new DbC();
	$li->connect();
	$crt = $li->selectall(LARY[$langid]);	
	exit (json_encode([
	"resultrequest"=> "OK",
	"Language"=>FORHTML[$langid],
	"crtlist"=>$crt
	],JSON_UNESCAPED_UNICODE));
	} 
}