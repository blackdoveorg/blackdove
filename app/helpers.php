<?php

function getleanhex($social, $economic)
{
    $data = file_get_contents('img/2axis4color.png');
    $image = imagecreatefromstring($data);
    $x = 50+(5*$economic);
    if ($x < 0) {
        $x = 0;
    };
    if ($x > 99) {
        $x = 99;
    } 
    $y = 50+(-5*$social);
    if ($y < 0) {
        $y = 0;
    };
    if ($y > 99) {
        $y = 99;
    }
    // $x = 99;
    // $y = 99;
    $rgb = imagecolorat($image, $x, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    $hex = sprintf("%02x%02x%02x", $r, $g, $b);
    if ($x == 50 && $y == 50) {
        $hex = 'a0a0a0';
    }
    return $hex;
}
