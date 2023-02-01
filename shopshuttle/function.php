<?php
ini_set('display_errors', '1');
define('DBPAR', implode(':', ['u28769', 'KBwukYEbuzTZ', 'db28769']));
define('DBHOST', 'mysql05.manitu.net');
//var_dump(DBPAR);
//echo DBHOST;
require 'Dbo.php';

include_once 'dbtables.php';

$fake_update = [
    "cat_num" => 1,
];
$delete = "DELETE FROM bike_category WHERE cat_id = 21;";
$statement = [$delete];
//var_dump(Dbo::getInstance());

$dbo = Dbo::getInstance();

//$dbo->do_statement($statement);
//$dbo->update('bike_category', $fake_update, 'cat_id=2');

$inserts[] = [
    "cat_num" => 4,
    "cat_name" => 'Motorrad XXL über 280kg bis 450kg',
    "infotext" => 'Harley Street Glie, Honda Goldwing, E-Kabinenroller',
];
// $inserts[] = [
//     "cat_num" => 5,
//     "cat_name" => 'Quad-ATV',
//     "infotext" => 'Sonderkategorie',
// ];

//$dbo->insert_batch('bike_category', $inserts);

$res = $dbo->select('transportcosts', ['country' => 'D', 'tcategory' => 1]);
$res2 = $dbo->raw_query("SELECT * FROM bike_category ORDER BY cat_num ASC");

function add_opt($obj) {
    return '<option value="'.$obj->id.'">'.$obj->tarif.' ... '. $obj->standard.'</option>';
}

function get_ctl($res) {
    $ctl = '<select class="form-control">';
    //$ctl.= array_walk($res, 'add_opt');
    foreach($res as $v) {
        $ctl.= add_opt($v);
    }
    $ctl.= '</select>';

    return $ctl;
}

include 'shop_head.php';
?>

<div class="container mt-4">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <?php 
                        echo get_ctl($res); 
                        echo $dbo->print_pre($res2);
                        ?>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'shop_footer.php';