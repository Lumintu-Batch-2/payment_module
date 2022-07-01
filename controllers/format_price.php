<?php

    function format_price($price) {
        $price_text = (string)$price; // convert into a string
        $price_text = strrev($price_text); // reverse string
        $arr = str_split($price_text, "3"); // break string in 3 character sets

        $price_new_text = implode(".", $arr);  // implode array with comma
        $price_new_text = strrev($price_new_text); // reverse string back
        return $price_new_text; // will output 1,234
    }