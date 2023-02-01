<?php
//include 'libs/foo.php';
include 'inc.php';

$item = ($_GET['item']) ? $_GET['item'] : 'Audi A6';

$foo = new Foo\FooFighter();
//var_dump($foo);
$s = new Shopping\Cart();
$chk = new Shopping\Checkout();

$s->setCart($item);

include 'header.php';
?>
<div class="container" style="margin-top: 20px;">

   <div class="row">

      <div class="col">
        <h1>Example Foo: <small class="text-muted">NS: Foo</small> </h1>
        <p><?=$foo->getMessage()?></p>

        <h2>example Cart (NS: Shopping):</h2>
        <p><?=$s->getCart()?></p>
      </div>

    </div>
   <div class="row">
   <h2>Checkout <small class="text-muted">(NS: Shopping)</small></h2>
    <?=$chk->do_checkout()?>

   </div>
</div>
<?php include 'footer.php';?>