<?php
    require "./libcheck.php";
    include "./keys.php"; // becuz adding and removing the wskey before/after each commit sucks

    $libSymbols = array("EVI");
    $wskey = WSKEY;

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

    echo "<br /><br />";

    /**
     *  TEST: Prints out link for Lil' Bub
     */

    $response = $check->search("1592408508");
    if ($response) {
        echo "<a href=\"{$response}\">Link to that item in its catalog!</a>";
    } else {
        echo "It doesn't look like we own that book!";
    }



?>
