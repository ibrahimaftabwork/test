<?php
/**
 * Created by PhpStorm.
 * User: ibrahim
 * Date: 29-Sep-16
 * Time: 5:13 PM
 */

$resolution = [
    'Desktop Screens' => [
        'Desktop Large Screen' => 1200,
        'Desktop Medium Screen' => 1024,
        'Desktop Small Screen' => 980
    ],
    'Tablet Screens' => [
        'Tablet Large Screen' => 960,
        'Tablet Medium Screen' => 800,
        'Tablet Small Screen' => 640
    ],
    'Mobile Screens' => [
        'Mobile Large Screen' => 767,
        'Mobile Medium Screen' => 580,
        'Mobile Small Screen' => 320,
    ]
];


foreach ($resolution as $Type => $res) {
    echo $Type . ' : <br>';
    foreach($res as $size_type => $size) {
        echo $size_type." - ".$size."<br>";
    }
    echo $Type . '<br><br><br>';
}
