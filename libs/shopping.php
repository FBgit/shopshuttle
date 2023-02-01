<?php
namespace Shopping;


class Cart {

    private $myCart = "";

    public function setCart($item) {
        $this->myCart = $item;
    }
    public function getCart() {
        return "<b>Whats in my shopping bag: </b>".$this->myCart;
    }

}

class Checkout{
    // Teste Checkout
    function do_checkout() {
        $bscode = '<div class="card">
        <div class="card-body">
          Do checkout now!!
        </div>
      </div>';

      return $bscode;
    }
}