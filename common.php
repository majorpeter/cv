<?php
//ini_set("default_charset", 'utf-8');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$pg_title = "Major Péter @BME-VIK";

$navlinks=array();
$navlinks[]=array('Kezdõlap','index.php');
$navlinks[]=array('Letöltések','downloads.php');
$navlinks[]=array('Rólam','about.php');
$navlinks[]=array('Kapcsolat','contact.php');

$content=array();
$head = "";

include('inc/quote.php');

function finish() {
	global $pg_title, $head, $quote, $quote2;
	set_quote();
	$f = file_get_contents('inc/theme.html');
	header("Content-type: text/html; charset=utf-8");
	echo(str_replace(
	array('{PG_TITLE}', '{HEAD}', '{NAVLINKS}', '{CONTENT}', '{QUOTE}', '{QUOTE2}'), array($pg_title, $head, get_navlinks(), get_content(), $quote, $quote2),$f));
}

function this_file() {
	$ary = explode('/', $_SERVER['PHP_SELF']);
	return($ary[count($ary)-1]);
}

function get_navlinks() {
	global $navlinks;
	$f = this_file();
	$res = '';
	foreach ($navlinks as $nav) {
		$curr = (strpos($nav[1], $f) !== false);
		$res.=get_navlink($nav[1], $nav[0], $curr);
	}
	return ($res);
}

function get_navlink($url, $title, $curr) {
	return('<li><a href="'.$url.'"'.($curr ? ' class="current"' : '').'>'.$title.'</a></li>');
}

function get_content() {
	global $content;
	$res = '';
	foreach ($content as $c)
		$res.=$c;
	return $res;
}

function add_page_entry($title, $html) {
	global $content;
	$content[]=/*utf8_decode*/('<h2>'.$title.'</h2>'.$html);
}
?>
