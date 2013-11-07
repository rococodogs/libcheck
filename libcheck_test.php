<?php
    require "./libcheck.php";

    $libSymbols = array("EVI");
    $wskey = "";

    $check = new Libcheck($libSymbols, $wskey);

    /**
     *  TEST: checks Trexler Library for Lil' Bub's Big Book (which we own)
     */

    $check->search("1592408508", function($err, $url) {
        if ($err) {
            echo $err;
            return false;
        } else {
            echo $url;
        }
    });

    echo "<br /><br />";

    /**
     * TEST: ISBN number that doesn't exist. Should return an error
     */

    $check->search("1592408507", function($err, $url) {
        if ($err) {
            echo $err;
            return false;
        } else {
            echo $url;
        }
    });

?>