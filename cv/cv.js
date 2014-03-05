/**
*	Major P�ter �n�letrajz�nak r�sze
*	(c) MP 2012
*/

function show_part(id) {
	document.getElementById("pbtn"+id).innerHTML = '[-]';
	document.getElementById("pbtn"+id).onclick = function() {hide_part(id)};
	document.getElementById("pd"+id).style.display = '';
}

function hide_part(id) {
	document.getElementById("pbtn"+id).innerHTML = '[+]';
	document.getElementById("pbtn"+id).onclick = function() {show_part(id)};
	document.getElementById("pd"+id).style.display = 'none';
}

function show_pbut(id) {
	document.getElementById("pbtn"+id).style.display = '';
}

function hide_pbut(id) {
	document.getElementById("pbtn"+id).style.display = 'none';
}
