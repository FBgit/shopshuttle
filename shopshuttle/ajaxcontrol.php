<?php
include 'loader.php';

use App\Transport;

$trans = new Transport();

$dbo = Dbo::getInstance();


// DB Version
function tarif_control($tarife, $extra)
{
    $tmp = '<label class="mb-2" for="country">Entfernung zum Ziel</label>';
    $tmp .= '<select class="form-control" name="prices" onchange="validate_test(this.value)">';
    $tmp .= '<option value="-">Tarifauswahl erforderlich</option>';
    foreach($tarife as $tarif) {
        $short = $tarif->tarif  . ' ... ' .$tarif->$extra;
        //$tmp .= '<option value="' . $tarif->$extra . '">' . $tarif->tarif  . ' ... ' .$tarif->$extra .  ' €</option>';
        $tmp .= '<option value="' . $short . '">' . $short .  ' €</option>';
    }

    $tmp .= '</select>';
    return $tmp;
}

$kat = (isset($_GET['kat'])) ? $_GET['kat'] : 'keine';

$region = 'D'; // deutschland
$premium = 'standard'; // standard

switch($_GET['region']) {
    case 'DES':
        $premium = 'standard';
        break;
    case 'DEE':
        $premium = 'exclusive';
        break;
    case 'A':
        $premium = 'standard';
        $region = 'A';
        break;
    case 'AT':
        $premium = 'standard';
        $region = 'AT';
        break;
        default:
        $region = 'D';
        $premium = 'standard';
}

if ($kat != '-') {
    //echo $selectControl;
    $sql = "SELECT * FROM transportcosts WHERE country='$region' AND tcategory=$kat ORDER BY sort ASC";
    $res = $dbo->raw_query($sql);
    echo tarif_control($res, $premium);

} else {
    echo "Kategorie ist : $kat";
}