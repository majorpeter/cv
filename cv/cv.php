<?php

$head.='<script type="text/javascript" src="cv/cv.js"></script>'."\n";
$head.='<link href="cv/cv.css" rel="stylesheet" type="text/css" />'."\n";
$head.='<script type="text/javascript" src="js/jquery.js"></script>'."\n".
		'<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>'."\n".
		'<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />'."\n";
$head.='<script type="text/javascript">$(function() {$(\'.lightbox\').lightBox();});</script>';

$pg = '';

$xml = simplexml_load_file('cv/cv.xml');
$title = $xml->title->$lng;
$update=$xml->update;

$pg='<img src="content/etc/img.jpg" class="profimg"/>';
$pg.= '<h3 class="cvtitle">'.$xml->name.'</h3>';


$pg.='<div class="leftbox"><span class="profile">';
foreach ($xml->desc as $desc)
	$pg .= $desc->$lng . '<br/>';
$pg .= '</span><br/>';

$pg .= $xml->phone->$lng.': <b>'.$xml->phone->val.'</b><br/>';
$pg .= $xml->mail->$lng.': <b>'.$xml->mail->val.'</b><br/>';
$pg .= $xml->fbook->$lng.': <b>'.$xml->fbook->val.'</b><br/>';
$pg .= '</div>';

foreach ($xml->section as $sec) {
	$pg .= '<h4 class="cvhead">'.$sec->title->$lng.'</h4>';
	foreach($sec->children() as $c) {
		if ($c->getName() == 'expand') {
			$titl = $c->title->$lng->asXML();
			$attr = $c->title->attributes(); 
			if (isset($attr['year']))
				$titl .= ' ('.$attr['year'].')';
			if (isset($attr['years']))
				$titl = $attr['years'].' '.$titl;
			if (isset($attr['list']))
				$titl = '&nbsp;&bull;&nbsp;'.$titl;
			$cont = cv_replace($c->content->$lng->asXML());
			
			$img = $c->image;
			if ($img->count()) {
				$cont .= '<br/><br/><div style="text-align: center; padding-top: 5px;">';
				foreach ($img as $i) {
					$cont .= '<a href="'.$i->url.'" class="lightbox" title="'.$i->$lng.'">';
					$a = $i->attributes();
					if (!isset($a['hidden']))
						$cont .= '<img src="'.$i->url.'" style="width: 100px; margin: 3px;"/>';
					$cont .= '</a>';
				}
				$cont .= '</div>';
			}
			create_popup(cv_replace($titl), $cont);
		}
		else if ($c->getName() == 'nonexpand')
			$pg .= '<div class="popuptitle">'.$c->$lng.'</div>';
		else if ($c->getName() == 'break')
			$pg .= '<br/>';
		else if ($c->getName() == 'content')
			$pg .= '<span class="profile">'.$c->$lng->asXML().'</span>';
	}
	$pg .= '<br/>';
}

file_put_contents(__DIR__.'/cv_data_'.$lng.'.html', $pg);

function cv_replace($subject) {
	return str_replace('\\nbsp', '&nbsp;', $subject);
}
?>
