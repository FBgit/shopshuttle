<?php
session_start();
require 'loader.php';

//$pay = new App\Payment;
$item = new App\Item;

// Read some dealers
$dbo = Dbo::getInstance();
$sql = "SELECT * FROM wp_dealers ORDER BY username ASC LIMIT 10";
$res = $dbo->raw_query($sql);

$included_user = '<p>' . buildOpts($res) . '</p>';
$modal = $item->modalPop('b2b-modal', 'B2B-Login', $included_user, 'md-login', 'Anmelden');

function buildOpts($res)
{
    $options = '';
    foreach ($res as $opts) {
        $options .= '<option value="' . $opts->id . '">';
        $options .= $opts->company;
        $options .= '</option>';
    }

    return '<select class="form-control">' . $options . '</select>';
    // return count($res);
}

$the_title = "Shop - Privat B2B";
include_once 'bs_header.php';
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h3>Auswahl ob Privat oder B2B Kunde (B2B Login)</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
            <button class="btn btn-warning" type="button" onclick="alert('Privatkunde - daten werden zum Schluß eingegeben!')">Privat</button>
            <button class="btn btn-success" type="button"  data-bs-toggle="modal" data-bs-target="#b2b-modal">B2B-Kunde</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                    <p class="pb-4">Aktuelle Auswahl (zum testen)</p>
        <?php
if (isset($_POST['country'])) {
    foreach ($_POST as $key => $val) {
        $_SESSION[$key] = $val;
        echo $key . ': ' . $val . '<br>';
    }
    //header('Location: shop.php');
    // echo "Super Session!<br><pre>";
    // print_r($_SESSION);
    // echo "</pre>";
} else {
    echo '<div class="alert alert-info">Error occured!</div>';
}
?>
        <a class="btn btn-primary" href="shop.php">Weiter zur Bestellung</a>
            </div>
        </div>


    </div>
    <?php echo $modal; ?>
    <?php include_once 'bs_footer_scripts.php';?>
    <?php include_once 'bs_footer.php';?>
