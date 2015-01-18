<?php
$save = @$_SERVER['argv'][1]=='update';
if (!$save) {
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
    
    $pg .= '<img class="cv-contact" title="' . $xml->phone->$lng.'" src="cv/contact-phone.png"/>' . $xml->phone->$lng.': <b><a>'.$xml->phone->val.'</a></b><br/>';
    $pg .= '<img class="cv-contact" title="' . $xml->mail->$lng.'"src="cv/contact-mail.png"/>' . $xml->mail->$lng.': <b><a href="mailto:'.$xml->mail->val.'">'.$xml->mail->val.'</a></b><br/>';
    $pg .= '<img class="cv-contact" title="' . $xml->linkedin->$lng.'"src="cv/contact-linkedin.png"/>' . $xml->linkedin->$lng.': <b><a href="'.$xml->linkedin->val.'">'.$xml->linkedin->val.'</a></b><br/>';
    $pg .= '<img class="cv-contact" title="' . $xml->fbook->$lng.'"src="cv/contact-facebook.png"/>' . $xml->fbook->$lng.': <b><a href="'.$xml->fbook->val.'">'.$xml->fbook->val.'</a></b><br/><br/>';
    if (@$_GET['print'])
    $pg .= $xml->cv->$lng.': <b><a href="'.$xml->cv->val.'">'.$xml->cv->val.'</a></b>';
    $pg .= '</div>';
    
    foreach ($xml->section as $sec) {
        $img = '';
        $attr = $sec->attributes();
        if ($attr['icon']) $img = '<div class="icon"><img src="'.$attr['icon'].'"/></div>';
        
    	$pg .= '<h2 class="cvhead">'.$img.$sec->title->$lng.'</h2>';
    	foreach($sec->children() as $c) {
    		if (($xmltag=$c->getName()) == 'li' || $xmltag == 'item') {
    			$titl = substr($c->title->$lng->asXML(), 4, -5);
    			$attr = $c->attributes();
                $id = @$attr['id'];
    			$attr = $c->title->attributes(); 
    			if (isset($attr['year']))
    				$titl .= ' ('.$attr['year'].')';
    			if (isset($attr['years']))
    				$titl = $attr['years'].' '.$titl;
    			if (isset($attr['image'])) {
    			    $image = '<img class="section" src="cv/'.$attr['image'].'"/>';
    			    if (isset($attr['image-full']))
    			        $image = '<a href="cv/'.$attr['image-full'].'" class="lightbox" title="'.$titl.'">'.$image.'</a>';
    			    $titl = $titl.$image;
                }
                
                $cont = @$c->content;
                if ($cont) {
                    $cont = @$cont->$lng->asXML();
    			     $cont = cv_replace(substr($cont, 4, -5));
                }
    			
    			$img = $c->image;
    			if ($img->count()) {
    				$cont .= '<br/><br/><div style="text-align: center; padding-top: 5px;">';
    				foreach ($img as $i) {
    					$cont .= '<a href="cv/'.$i->url.'" class="lightbox" title="'.$i->$lng.'">';
    					$a = $i->attributes();
    					if (!isset($a['hidden']))
    						$cont .= '<img src="cv/'.$i->url.'" style="max-width: 100px; max-height: 100px; margin: 3px;"/>';
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

                if (!@$_GET['print'])
    			    create_popup(cv_replace($titl), $cont, $xmltag=='li', $id);
                else
                    $pg .= '<div class="popuptitle">'.(($xmltag=='li') ? '&bull; ' : '').cv_replace($titl).'</div>';
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
    // csak töltse be a cache fájlokat
	$pg = file_get_contents('cv/cv_data_'.$lng.'.html');
    $update = file_get_contents('cv/cv_update.txt');
}

/**
 * xml nem tartalmazhat nbsp entitést
 */
function cv_replace($subject) {
	return str_replace('\\nbsp', '&nbsp;', $subject);
}
?>
