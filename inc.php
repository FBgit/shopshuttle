<?php
    function my_autoload ($pClassName) {
        //echo $pClassName; exit;
        $c = explode('\\', $pClassName);
        $classFile = strtolower($c[0]);
        //echo __DIR__ .'/libs/'. $classFile; exit;
        include(__DIR__ ."/libs/" . $classFile . ".php");
    }
    spl_autoload_register("my_autoload");
?>