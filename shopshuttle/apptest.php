<?php

// load all required files
require __DIR__.'/loader.php';

use App\Item;
use App\Payment;
use App\Stripe;

$item = new Item();
$pay = new Payment();
$stripe = new Stripe();

//var_dump($item);
$classList = [$item, $pay, $stripe];

function get_cl($obj) {
   //$c = var_dump($obj);
    $obj->get_info();
    echo "<br><br>";
}

array_walk($classList, 'get_cl');