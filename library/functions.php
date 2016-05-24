<?php


function inputHas($key) {
    $requestCheck = isset($_REQUEST[$key]);
    return $requestCheck;
}

function inputGet($key) {
    if (inputHas($key) == true) {
        return $_REQUEST[$key];
    } else {
        return null;
    }
}

function escape($input) {
    return htmlspecialchars(strip_tags($input));
}
