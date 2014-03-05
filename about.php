<?php
	include('common.php');
	$popup_id = 0xED;	
	
	$lng = 'hu';
	if (isset($_GET['lng'])) {
		$lng = $_GET['lng'];
		if (!in_array($lng, array("hu", "en")))
			$lng = "hu";	//hack ellen :D
	}
	
	include('cv/cv.php');

	if (isset($_GET['print'])) {
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n".
			'<html xmlns="http://www.w3.org/1999/xhtml">'."\n".
				'<head>'."\n".
				'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".
				'<title>Major Péter önéletrajz</title>'."\n".
				$head."\n".
				'<link href="cv/cv_print.css" rel="stylesheet" type="text/css" />'."\n".
				'</head>'."\n".'<body>'."\n";
		echo $pg;
		echo '</body></html>';
		die();
	}
	else if (isset($_GET['xml'])) {
		$file = 'cv/cv.xml';
		header('Content-Description: File Transfer');
	    header('Content-Type: text/xml');
	    header('Content-Disposition: attachment; filename=mp-cv-'.$update.'.xml');
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    ob_clean();
	    flush();
	    readfile($file);
	    exit;
			
	}
	
	$pg.='<br /><br /><br /><a href="?print=1">Nyomtatható verzió</a>';
	$pg.='&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?xml=1">Letöltés XML-ként</a>';
	if ($lng != "en")
		$pg.='&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?lng=en">Angol nyelven (in English) !Fordítás alatt!</a>';
	if ($lng != "hu")
		$pg.='&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?lng=hu">Magyar nyelven</a>';

	$pg = '<p align="right">Utolsó frissítés: <b>' . $update . '</b></p>' . $pg;
	
    $title = ($lng == 'hu') ? 'Önéletrajz' : 'Curriculum Vitae'; 
	add_page_entry($title, $pg);
	finish();
	
function create_popup($title, $content, $title_style = 'popuptitle', $content_style = 'popupcontent') {
	global $pg, $popup_id;
	
	$pg.='<div onmouseover="show_pbut('."'$popup_id'".');" onmouseout="hide_pbut('."'$popup_id'".
		');"><div class="'.$title_style.'">'.$title.' <span id="pbtn'.$popup_id.'" onclick="show_part('."'$popup_id'".');" class="pbtn" style="display: none;">[+]</span></div>'.
		'<div id="pd'.$popup_id.'" style="display: none;" class="'.$content_style.'">'.$content.'</div></div>';
	$popup_id++;
}
?>
