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
				'<link href="cv/cv_print.css" rel="stylesheet" type="text/css" />'."\n".
				'<script type="text/javascript" src="js/jquery.js"></script>'."\n".
				'<script type="text/javascript" src="cv/cv.js"></script>'."\n".
                $head."\n".
				'</head>'."\n".'<body>'."\n";
		echo $pg;
		echo '</body></html>';
		exit;
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
    else $head.= '<script type="text/javascript" src="cv/cv.js"></script>'."\n";
	
    $precontent = '<a href="?print=1"><img src="img/print.png"/>Nyomtatható verzió</a>';
	$precontent.='<a href="?xml=1"><img src="img/xml-ico.png"/>Letöltés XML-ként</a>';
	if ($lng != "en")
		$precontent.='<a href="?lng=en"><img class="lng" src="img/lng_en.png"/>Angol nyelven (in English) (Fordítás alatt)</a>';
	if ($lng != "hu")
		$precontent.='<a href="?lng=hu"><img class="lng" src="img/lng_hu.png"/>Magyar nyelven</a>';

	$pg = '<p align="right">Utolsó frissítés: <b>' . $update . '</b></p>' . $pg;
	
    $title = ($lng == 'hu') ? 'Önéletrajz' : 'Curriculum Vitae'; 
	add_page_entry($title, $pg);
	finish();
	
function create_popup($title, $content = '', $li = false, $id = null) {
	global $pg, $popup_id;
    
    if (!$title) return;
    
    if ($content)
    	$pg.='<div data-id="'.$popup_id.'"><div class="popuptitle'.($li ? ' li' : '').' toggle"><span class="toggle'.($li ? '' : ' hide').'"></span>'.$title.'</div>'.
    		'<div id="pd'.$popup_id.'" style="display: none;" class="popupcontent">'.$content.'</div></div>';
    else
        $pg.='<div class="popuptitle">'.($li ? '&bull;&nbsp;' : '').$title.'</div>';
	$popup_id++;
}
?>
