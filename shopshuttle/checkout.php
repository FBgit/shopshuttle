<?php
session_start();
require 'autoloader.php';

$pay = new App\Payment;
// $item = new App\Item;
// $item->get_info();exit;

$name = $pay->inputField('name', '', '* Name');
$abholort = $pay->checkBox('abholen-bei-ag', 'Auftraggeber Anschrift', "showBox('a-box', this)");
$zielort = $pay->checkBox('liefern-zu-ag', 'Auftraggeber Anschrift', "showBox('z-box', this)");

$adressdata = [
    "name" => "Vorname",
    "lastname" => "Name",
    "anschrift" => "Anschrift mit Nr",
    "plz" => "PLZ",
    "ort" => "City",
    "tel" => "Telefon",
    "email" => "E-Mail",
];

function genAdressblock($arr, $origin)
{
    $paym = new App\Payment;
    $tmp = "";
    foreach ($arr as $k => $f) {
        $tmp .= $paym->inputField($origin . '_' . $k, '', $f);
    }

    return $tmp;
}

$abholer = genAdressblock($adressdata, 'abholer');
$zieladresse = genAdressblock($adressdata, 'ziel');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShopShuttle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="shop.css" media="screen">
</head>

<body>

    <div class="container">
        <h1>Bike<span class="shophead">Shuttle</span> Checkout ;)</h1>
        <div class="d-flex justify-content-between">
            <p class="marker">
                Bestellung abschließen! Die Buttons sind nur zum testen.
            </p>
            <button class="btn btn-outline-danger" onclick="devToggle()">Developer view cart ...</button>
        </div>
        <div id="hid-cart" style="display:none;">
            <h3>What's in the cart?</h3>
            <pre>
            <?php print_r($_SESSION);?>
        </pre>
        </div>
        <div class="row">
            <div id="button-bar" class="col-md-12">
                <a href="#" onclick="window.history.back()" class="btn btn-outline-primary">Bestellung ändern</a>
                <a href="#" onclick="pasteB2B()" class="btn btn-outline-secondary">B2B Kunde</a>
                <a href="#" onclick="pastePrivate()" class="btn btn-outline-success">Privater Kunde</a>
                <button type="button" class="btn btn-primary" onclick="fillSender('abholer', abholer)">Fülle Abholort</button>
                <button type="button" class="btn btn-secondary" onclick="fillSender('ziel', empf)">Fülle Zielort</button>
            </div>
        </div>
        <div id="response" class="mt-3"></div>
        <div id="checkoutform">
            <form action="" class="form" id="chk-form">
                <div class="row">
                    <div class="col-md-4">
                        <div id="ageber"></div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="pt-3">Abholort</h3>
                        <?=$abholort?>
                        <div id="a-box"><?=$abholer?></div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="pt-3">Zielort <small>Lieferadresse</small></h3>
                        <?=$zielort?>
                        <div id="z-box"><?=$zieladresse?></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mb-5">Kostenpflichtg bestellen!</button>
                    </div>
                </div>
            </form>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="checkout.js"></script>
    <script>
    function devToggle() {
        $('#hid-cart').toggle();
    }
    $(document).ready(function() {
        pastePrivate();
    })

    function showBox(box, sender) {
        vis = 'block';
        if (sender.checked) {
            vis = "none";
        }

        document.getElementById(box).style.display = vis;

    }

    const abholer = ["Elisa", "Hommerl", "Röschengasse 45", "02906", "Niesky", "03588-124569", "elisa@mail.de"];
    const empf = ["Sven", "Schuster", "Graben 2345", "02906", "Horscha", "03588-545789", "sven@mail.de"];

    function fillSender(prefix, arr) {
        $("#"+prefix+"_name").val(arr[0]);
        $("#"+prefix+"_lastname").val(arr[1]);
        $("#"+prefix+"_anschrift").val(arr[2]);
        $("#"+prefix+"_plz").val(arr[3]);
        $("#"+prefix+"_ort").val(arr[4]);
        $("#"+prefix+"_email").val(arr[5]);
        $("#"+prefix+"_tel").val(arr[6]);
    }
    </script>
</body>

</html>