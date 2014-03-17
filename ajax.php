<?php
header('Content-Type: text/plain; charset=utf-8');

if (!$_POST['name'] || $_POST['name'] == 'név')
    $error = array(
        'errormsg' => 'Név megadása kötelező!',
        'field' => 'name'
    );
elseif (!$_POST['email'] || $_POST['email'] == 'email')
    $error = array(
        'errormsg' => 'Email cím megadása kötelező!',
        'field' => 'email'
    );
elseif (!$_POST['message'] || $_POST['message'] == 'üzenet')
    $error = array(
        'errormsg' => 'Üzenet kitöltése kötelező!',
        'field' => 'message'
    );


if (@$error) {
    echo $error['errormsg']."\n".$error['field'];
    exit;
}

mail('major.peter@mailbox.hu', 'HSZK Site levél',
'Talán tudod, de ez egy automatikus üzenet, azért kaptad, mert te vagy te.

Valaki kitöltötte a kontakt formodat, íme a részletek:

Név: '.$_POST['name'].'
Email: '.$_POST['email'].'
Üzenet: '.$_POST['message'].'

Tisztelettel: Ural2');
echo 'A levelet elküldtem.';
?>