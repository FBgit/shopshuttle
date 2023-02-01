<?php
session_start();
ini_set('display_errors', '1');
if (isset($_POST)) {
    $test = checkEmptyPost('manufacturer', "Hersteller");
    $test .= checkEmptyPost('modell', "Modell");
    $test .= checkEmptyPost('abholdatum', "Abholbereit Datum");
    $test .= checkEmptyPost('your-text', "Bemerkungen");
    $test .= checkEmptyPost('gewicht', "Fahrzeuggewicht");

    $test .= validateService();

    if (!empty($test)) {
        echo alertBox('Einige Angaben fehlen!', 'info');
        echo alertBox($test, 'danger');
    } else {
        $message = "<h3>Bestellung-Übersicht:</h3><br>";
        //$message.= listPosts();
        $message .= 'Hersteller: ' . getPostVal('manufacturer') . '<br>';
        $message .= 'Modell: ' . getPostVal('modell') . '<br>';
        $message .= 'Leergewicht: ' . getPostVal('gewicht') . '<br>';
        $message .= 'Abholdatum: ' . getPostVal('abholdatum') . '<br><br>';
        $message .= getServiceOptions('treuhand') . '<br>';
        $message .= getServiceOptions('nachnahme') . '<br><br>';
        $message .= getServiceOptions('extrateile', 'nicht vorhanden') . '<br>';
        $message .= getServiceOptions('umbauten', 'keine Umbauten') . '<br><br>';
        $message .= 'Bemerkungen: ' . getPostVal('your-text') . '<br>';

        $dev = listPosts();

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

// Treuhand und NN anzeigen
function getServiceOptions($service, $customText = "nicht gewählt")
{
    // enthaltene service optionen
    $service_opts = [
        "extrateile" => "Karton Extrateile",
        "umbauten" => "Umbauten vorhanden",
    ];

    //
    if (isset($_POST[$service]) && !empty($_POST[$service])) {
        $service_label = ucwords($service);
        return ($service == 'treuhand' or $service == 'nachnahme') ? $service_label . ': <b>Kaufpreis: </b>' . getPostVal('your-after') : $service_label . ': ' . $service_opts[$service];
    } else {
        return ucwords($service) . ' : ' . $customText . '!';
    }
}

// List POSTS
function listPosts()
{
    $test = '';
    foreach ($_POST as $key => $val) {
        $_SESSION[$key] = $val;
        $test .= $key . ': ' . $val . '<br>';
    }

    return $test;
}

// check treuhand oder nn
function validateService()
{
    $nn = getPostVal('treuhand');
    $th = getPostVal('nachnahme');
    if (!empty($nn) or !empty($th)) {
        return checkEmptyPost('your-after', 'Kaufpreis bei Auswahl von  Nachname oder Treuhand');
    } else {
        return '';
    }
}

// Leere Felder
function checkEmptyPost($field, $attr)
{
    if (empty($_POST[$field])) {
        return "$attr ist erforderlich - bitte Ausfüllen<br>";
    } else {
        return '';
    }
}

// was ist im POST
function getPostVal($val)
{
    return (isset($_POST[$val])) ? $_POST[$val] : '';
}

// bootstrap alert
function alertBox($text, $class = "success")
{
    return '<div class="alert alert-' . $class . '">' . $text . '</div>';
}

function printCart()
{
    echo "<pre>";

    print_r($_POST);

    echo "</pre>";
}
