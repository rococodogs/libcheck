<?php
    require "./libcheck.php";
    include "./keys.php"; // becuz adding and removing the wskey before/after each commit sucks

    $libSymbols = array("EVI", "LCY");
    $wskey = WSKEY;

    /** 
     *  TEST: Checks Muhlenberg College Library and Lehigh Carbon Community College 
     *        for 'The Pale King', which we both own.
     *
     */
    $libcheck = new Libcheck($libSymbols, $wskey);
    echo "<h2>Both libraries own</h2>";
    echo "<pre>";
    print_r($libcheck->search("9780316074230"));
    echo "</pre>";


    /**
     *  TEST: Checks Muhlenberg and LCCC for invalid ISBN
     *
     */
   
    $libcheck = new Libcheck($libSymbols, $wskey);
    echo "<h2>Invalid ISBN</h2>";
    echo "<pre>";
    print_r($libcheck->search("9780316074232") ?: $libcheck->getMessage()); 
    echo "</pre>";    

    /**
     *  TEST: Neither library owns item
     *
     */
    
    $libcheck = new Libcheck($libSymbols, $wskey);
    echo "<h2>Neither library owns</h2>";
    echo "<pre>";
    print_r($libcheck->search("0000000000000") ?: $libcheck->getMessage());
    echo "</pre>";
?>
