<?php
$quote='';
$quote2='';

function set_quote() {
	global $quote, $quote2;
	$f = file_get_contents('content/etc/quote.txt');
	$q = explode("\n", $f);
	$a = rand(0, count($q)-1);
	while (strlen($q[$a]) > 1)
		$a--;
	$a++;
	
	while (strlen($q[$a]) > 1 ) {
		if ($q[$a][0] != '/')
			$quote.= $q[$a]."<br/>";
		else
			$quote2 = $q[$a];
		$a++;
	}
	
	if ($quote2 == "")
		$quote2 = "&nbsp;";
}
?>
