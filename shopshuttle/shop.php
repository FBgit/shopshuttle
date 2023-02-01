<?php
session_start();
$regions = [
    "DES" => "Deutschland Standard",
    "DEE" => "Deutschland Exklusiv",
    "A" => "Deutschland Ausland",
    "AT" => "Österreich",
];

$tarife = ["-", "E-Bikes", "Mofa, Roller bis 800ccm", "Motorrad über 80 ccm bis 999cm bis 210 kg", "Motorrad ab 1000 ccm ab 210 kg bis 280 kg"];

function sessionCart()
{
    $text = "";
    // if (isset($_SESSION['country'])) {
    //     $text = '<b>Region: </b>' . $regions[$_SESSION['country']] . '<br>';
    //     $text .= '<b>Kategorie: </b>' . $tarife[$_SESSION['kat']] . '<br>';
    //     $text .= '<b>Tarif: </b>' . $_SESSION['prices'] . ' &euro;<br>';
    // }

    return $text;
}

function getCart($regions, $tarife)
{

    $prices = [
        "-",
        "bis 100 km ... 404,00 EUR",
        "bis 200 km ... 606,00 EUR",
        "bis 300 km ... 808,00 EUR",
        "bis 400 km ... 1001,00 EUR",

    ];

    $text = "";

    $text = '<b>Region: </b>' . $regions[$_SESSION['country']] . '<br>';
    $text .= '<b>Kategorie: </b>' . $tarife[$_SESSION['kat']] . '<br>';
    $text .= '<b>Tarif: </b>' . $_SESSION['prices'] . ' &euro;<br>';

    return $text;
}

function inputField($name_id, $label, $ph, $value = "", $type = "text", $help = "")
{
    $tmp = ' <div class="mb-3">
        <label for="' . $name_id . '" class="form-label">' . $label . '</label>
        <input type="' . $type . '" class="form-control" name="' . $name_id . '" id="' . $name_id . '"  placeholder="' . $ph . '">';
    if (!empty($help)) {
        $tmp .= '<div id="' . $name_id . '-help" class="form-text">' . $help . '</div>';
    }
    $tmp .= '</div>';

    return $tmp;
}

function checkBox($name_id, $label, $help = "")
{
    $tmp = '<div class="mb-3 form-check">';
    $tmp .= '<input type="checkbox" class="form-check-input" id="' . $name_id . '" name="' . $name_id . '">';
    $tmp .= '<label class="form-check-label" for="' . $name_id . '">' . $label . '</label>';
    if (!empty($help)) {
        $tmp .= '<div id="' . $name_id . '-help" class="form-text">' . $help . '</div>';
    }
    $tmp .= '</div>';

    return $tmp;
}
$the_title = "Shop - Configure Your Bike";
include_once 'bs_header.php';
?>


    <div class="container">

        <div class="form-box">
            <h1>Bike<span class="shophead">Shuttle</span> Shop</h1>

            <div id="dev" class="mb-3"><a class="btn btn-outline-primary" href="#" onclick="fillForm()">Fake Daten füllen!</a>
            </div>
            <div class="alert alert-secondary"><?=getCart($regions, $tarife)?></div>
            <div id="success"></div>
            <div id="form-conti">
                <form name="shopform" action="" id="shopform" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="treuhand" name="treuhand">
                                <label class="form-check-label" for="exampleCheck1">Treuhandauftrag (Gebühr: 30,00
                                    EUR)</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="nachnahme" name="nachnahme">
                                <label class="form-check-label" for="exampleCheck2">Nachnahme (Gebühr: 30,00
                                    EUR)</label>
                                <input type="text" class="form-control mt-2" name="your-after" id="your-after"
                                    placeholder="Kaufsumme z.B 12.000,00 EUR">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=inputField('manufacturer', 'Hersteller', 'z.B. Honda', '', '', '');?>
                            <?=inputField('modell', 'Modell', 'z.B. Fireblade', '', '', 'Anbauteile müssen bei Abholung demontiert sein');?>
                            <?=inputField('gewicht', 'Leergewicht', 'z.B. 230kg', '', '', 'mit Tankinhalt');?>
                        </div>
                        <div class="col-md-6">
                            <?=inputField('abholdatum', 'abholbereit ab', '', date('d.m.Y'), 'date', '');?>
                            <?=checkBox('umbauten', 'Umbauten sind vorhanden', 'Bei nicht ordnungsgemäßer Angabe entstehen weitere Kosten
');?>
                            <?=checkBox('extrateile', 'Karton mit Extrateilen vorhanden', 'Bei nicht ordnungsgemäßer Angabe entstehen weitere Kosten
');?>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Bemerkungen zum Fahrzeug</label>
                        <textarea class="form-control" name="your-text" id="your-text" rows="3"></textarea>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Bestellen</button>
                        <button type="button" class="btn btn-danger mb-3"
                            onclick="window.location.href='index.php'">Cancel</button>
                    </div>
                </form>


            </div>

        </div>

    </div>

   <?php include_once 'bs_footer_scripts.php';?>

    <script>
    function fillForm() {
        $('#manufacturer').val('Yamaha');
        $('#modell').val('MT-09');
        $('#gewicht').val('215 kg');
        $('#abholdatum').val('2023-01-31');
        $('#your-text').val('Alter, was denn noch?');
    }
    $('#shopform').on('submit', function(e) {
        e.preventDefault();
        console.log('Prevented?');
        //let formData = $('#shopform').serialize();
        let formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "ajaxtest.php",
            data: formData,
            success: function(res) {
                $('#success').html(res);
                if (res.indexOf("fehlen") === -1) {
                    const go_button =
                        `<p><a class="btn btn-success" href="checkout.php">Abschliessen und zu den Lieferdaten</a> <a class="btn btn-warning" onclick="switchForm()" href="#">Bestellung ändern</a></p>`;

                    const templ_str =
                        `<h3>Prüfen Sie Ihre Bestellung!</h3><div class="card mb-3"><div class="card-body">${res}</div></div>${go_button}`;
                    $('#success').html(templ_str);
                    $('#form-conti').hide();
                    //pasteSomeText();
                }
            }

        });
    });

    function switchForm() {
        $('#form-conti').show();
        $('#success').html('');
    }

    function pasteSomeText() {
        $('#form-conti').append(`<div class="alert alert-info mt-3">Danke für Ihre Bestellung!</div>`);
    }
    $(document).ready(function() {
        $('#your-mail').val('Shop@bikeshuttle.de');

    });
    </script>
  <?php include_once 'bs_footer.php';?>
