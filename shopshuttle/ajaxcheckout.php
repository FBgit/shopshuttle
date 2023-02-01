<?php
session_start();
ini_set('display_errors', '1');
require 'app/Payment.php';
use App\Payment;

$pay = new Payment();


if(isset($_POST)) {
   $test = '';
   if(!isset($_POST['abholen-bei-ag'])) {
        $test.= checkAdress('abholer', $pay, "Abholung");
   } 
   if(!isset($_POST['liefern-zu-ag'])) {
       $test.= checkAdress('ziel', $pay, "Lieferadresse");
   } 
   
   if(isset($_POST['abholen-bei-ag']) && isset($_POST['liefern-zu-ag'])) {
        if($_POST['abholen-bei-ag'] == "on" && $_POST['liefern-zu-ag'] == "on") {
            $test.= "Fehler: es kann nur Abholort oder Lieferadresse die Auftraggeber-Anschrift sein!";
        }
   }
   
   
    if(!empty($test)) {
        echo $pay->alertBox('Einige Angaben fehlen!', 'info');
        echo $pay->alertBox($test, 'danger');
    } else {
        // $message = "<h3>Bestellung-Übersicht:</h3><br>";
        // //$message.= listPosts();
        // $message.= 'Hersteller: '.getPostVal('manufacturer').'<br>';
        // $message.= 'Modell: '.getPostVal('modell').'<br>';
        // $message.= 'Leergewicht: '.getPostVal('gewicht').'<br>';
        // $message.= 'Abholdatum: '.getPostVal('abholdatum').'<br><br>';
        // $message.= getServiceOptions('treuhand').'<br>';
        // $message.= getServiceOptions('nachnahme').'<br><br>';
        // $message.= getServiceOptions('extrateile').'<br>';
        // $message.= getServiceOptions('umbauten').'<br><br>';
        // $message.= 'Bemerkungen: '.getPostVal('your-text').'<br>';

        $message = listPosts();
        
        echo $message;
        // $headers[] = 'From: '.getPostVal('your-name') .' <'.getPostVal('your-mail').'>';
        // $headers[] = 'MIME-Version: 1.0';
        // $headers[] = 'Content-type: text/html; charset=utf-8';
        // $sent = mail('fbn@springer-net.de','Bestellung SHOP-App', $message, implode("\r\n", $headers));
        // if($sent) {
        //     echo "Mail ist raus!!";
        // }
    }




}

// Checkup Adressen
function checkAdress($prefix, $payment, $errortext) {
    $test = '';
    $test.= $payment->checkEmptyPost($prefix.'_name', "$errortext Name");
    $test.= $payment->checkEmptyPost($prefix.'_lastname', "$errortext Nachname");
    $test.= $payment->checkEmptyPost($prefix.'_anschrift', "$errortext Anschrift");
    $test.= $payment->checkEmptyPost($prefix.'_plz', "$errortext Postleitzahl");
    $test.= $payment->checkEmptyPost($prefix.'_ort', "$errortext Wohnort");
    $test.= $payment->checkEmptyPost($prefix.'_tel', "$errortext Telefon");
    $test.= $payment->checkEmptyPost($prefix.'_email', "$errortext E-Mail");
    return $test;
}


// List POSTS
function listPosts() {
    $test = '';
    foreach($_POST as $key => $val) {
        $_SESSION[$key] = $val;
        $test.= $key.': '.$val.'<br>';
    }

    return $test;
}