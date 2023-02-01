<?php

// call function
process_order();

function send_email($args) {
    $headers = "From: {$args['name']} <{$args['email']}>" . "\r\n";
	$mailtext = "Der Kunde {$args['name']} bestellt mit der Bermerkung:\n\n";
	$mailtext.= $args['message'];
    if(mail('info@fb-imedia.de', "ShopShuttle Order", $mailtext, $headers)) {
        return "Ihre Bestellung war erfolgreich!!";
    } else {	
        return "E-Mail nicht gesendet!!";
    }
}

function process_order() {
$fields = [
	"E-Mail" => "your-mail", 
	"Name" => "your-name", 
	"Bemerkungen" => "your-text"
];
$checkAll = checkPost($fields);

	if(isset($checkAll[0])){
		
		$err_string = implode('<br>', $checkAll);
		echo '<div class="alert alert-danger">'.$err_string.'</div>';
	}
	
	
if(!empty($_POST['your-text']) && is_array($_POST)) {
		$args = [
			'email' => $_POST['your-mail'],
			'name' => $_POST['your-name'],
			'message' => $_POST['your-text'],
		];

		echo '<div class="alert alert-info">'.send_email($args).'</div>';

	} else {
		echo '<div class="alert alert-danger">In ihrer Bestellung fehlen Daten!!</div>';
	}

}
	
function checkPost($args){
	$errors = [];	
	foreach($args as $key => $a) {
			if(empty($_POST[$a])) {
				$errors[] = "Angaben zu <b>$key</b> fehlen!";
				
			}
		}
	
	return $errors;
}