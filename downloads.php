<?php
	include('common.php');
	if (!isset($_GET['fn'])) {
		$dl = '';
		$d = opendir('./content/dl');
		while ($f = readdir($d))
			if ($f != '.' && $f != '..') {
				$dl.='<a href="?fn='.$f.'">'.$f.'</a><br />';
			}
		closedir($d);
		
		add_page_entry('Letöltések', $dl);
	}
	else {
		add_page_entry($_GET['fn'],file_get_contents('./content/dl-desc/'.$_GET['fn'].'.html').'<br /><br /><a href="content/dl/'.$_GET['fn'].'">Letöltés</a>');
	}
	finish();
?>
