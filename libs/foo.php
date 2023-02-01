<?php
namespace Foo;

class FooFighter {
    function __construct() {
        return "Aktueller Pfad: ". __DIR__;
    }

    public function getMessage() {
        return "I am Foo-Fighter!!";
    }
}

