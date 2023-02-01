<?php
session_start();

include 'loader.php';

use App\Transport;

$trans = new Transport();

$dbo = Dbo::getInstance();
$res2 = $dbo->raw_query("SELECT * FROM bike_category ORDER BY cat_num ASC");
//echo $dbo->print_pre($res2); exit;
$selected = new stdClass();
$selected->cat_id = 9999;
$selected->cat_num = '-';
$selected->cat_name = "Kategorie wählen";
$selected->infotext = "Kategorie wählen";
/*
--- COOL PHP7.4 feature ---
-- spread operator --

// Add an item before
$arr = [$item, ...$arr];

// Add an item after
$arr = [...$arr, $item];

// Add a few more
$arr = [$item1, $item2, ...$arr, $item3];

// Multiple arrays and and items
$arr = [$item1, ...$arr1, $item2, ...$arr2, $item3];

 */

// using spread OP to set on beginning
$res2 = [$selected, ...$res2];
// make control ready
$select = $trans->cat_control($res2);
$options = $trans->cat_options($res2);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>ShopShuttle</title>
    <link rel="stylesheet" href="shop.css" media="screen">
</head>

<body>
    <div class="container">

        <div class="form-box">
            <h1>Bike<span class="shophead">Shuttle</span> Shop</h1>
            <p class="form-heading">Transport wählen!</p>
            <div class="navcont">

            </div>
            <div class="alert alert-info">Preise und Auswahl nur beispielhaft, Demonstration der Funktionsweise</div>
            <div id="msg"></div>
            <div id="response"></div>
            <form class="form" action="cart.php" id="chooser" name="chooser" method="POST">

                <div id="C" class="form-group">
                    <label class="mb-2" for="country">Region für den Transport (DE, NL, AT)</label>
                    <select onchange="validate_region()" class="form-control mb-2" name="country" id="country">
                        <option value="NO"> -- </option>
                        <option value="DES">Deutschland - Standard</option>
                        <option value="DEE">Deutschland - Exclusive</option>
                        <option value="A">Deutschland - Ausland</option>
                        <option value="AT">Österreich</option>
                    </select>
                </div>
                <div id="cat" class="form-group" style="display:none;">
                    <label class="mb-2" for="country">Welches Motorrad möchten Sie transportieren?</label>
                    <select onchange="loadKat(this.value)" name="kat" id="kat" class="form-control mb-3">
                        <?=$options?>
                    </select>
                </div>
                <div id="category"></div>

                <button id="test" type="submit" class="btn btn-primary mt-3" style="display:none">Weiter mit Ihren
                    Daten</button>
            </form>

            <div id="tarife"></div>

        </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script src="shopfunction.js"></script>

</body>

</html>