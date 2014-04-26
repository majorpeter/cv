<?php
$save = @$_SERVER['argv'][1]=='update';
if (!$save) {
    $head.='<script type="text/javascript" src="cv/cv.js"></script>'."\n";
    $head.='<link href="cv/cv.css" rel="stylesheet" type="text/css" />'."\n";
    $head.='<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>'."\n".
            '<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />'."\n";
    $head.='<script type="text/javascript">$(function() {$(\'.lightbox\').lightBox();});</script>';
}

if (extension_loaded('simplexml')) {
    if ($save) $lng = $_SERVER['argv'][2];
    
    $xml = simplexml_load_file('cv/cv.xml');
    $title = $xml->title->$lng;
    $update=date('Y-m-d');
    if ($save) file_put_contents('cv/cv_update.txt', $update);
    
    $pg='<img src="content/etc/img.jpg" class="profimg"/>';
    $pg.= '<h1 class="cvtitle">'.$xml->name.'</h1>';
    
    
    $pg.='<div class="leftbox"><span class="profile">';
    foreach ($xml->desc as $desc)
    	$pg .= $desc->$lng . '<br/>';
    $pg .= '</span><br/>';
    
    $pg .= $xml->phone->$lng.': <b><a>'.$xml->phone->val.'</a></b><br/>';
    $pg .= $xml->mail->$lng.': <b><a href="mailto:'.$xml->mail->val.'">'.$xml->mail->val.'</a></b><br/>';
    $pg .= $xml->fbook->$lng.': <b><a href="'.$xml->fbook->val.'">'.$xml->fbook->val.'</a></b><br/>';
    $pg .= '</div>';
    
    foreach ($xml->section as $sec) {
        $img = '';
        $attr = $sec->attributes();
        if ($attr['icon']) $img = '<div class="icon"><img src="'.$attr['icon'].'"/></div>';
        
    	$pg .= '<h2 class="cvhead">'.$img.$sec->title->$lng.'</h2>';
    	foreach($sec->children() as $c) {
    		if ($c->getName() == 'expand') {
    			$titl = substr($c->title->$lng->asXML(), 4, -5);
    			$attr = $c->title->attributes(); 
    			if (isset($attr['year']))
    				$titl .= ' ('.$attr['year'].')';
    			if (isset($attr['years']))
    				$titl = $attr['years'].' '.$titl;
    			$cont = cv_replace(substr($c->content->$lng->asXML(), 4, -5));
    			
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
                
                if ($c->tag->count())
                    foreach ($c->tag as $t) {
                        $tag = null;
                        foreach ($xml->tag as $xt) {
                            if ($xt->name->__toString() == $t->__toString()) {
                                $tag = $xt;
                                break;
                            }
                        }
                        if (!$tag) {
                            echo 'Hiányzó tag: '.$t->__toString().'!<br/>';
                            continue;
                        }
                        $titl.='<span class="tag '.$tag->name.'" title="'.htmlentities($tag->desc->$lng->__toString()).'">'.$tag->title->$lng.'</span>';
                    }

    			create_popup(cv_replace($titl), $cont, 'popuptitle', 'popupcontent', isset($attr['list']));
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
    
    if ($save) {
        file_put_contents('cv/cv_data_'.$lng.'.html', $pg);
        exit;
    }
}
else {
	$pg = file_get_contents('cv/cv_data_'.$lng.'.html');
    $update = file_get_contents('cv/cv_update.txt');
}


function cv_replace($subject) {
	return str_replace('\\nbsp', '&nbsp;', $subject);
}
?>
