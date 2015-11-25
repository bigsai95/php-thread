<?php
require __DIR__.'/../vendor/autoload.php';

use Aban\Thread\Forker;

$p = new Forker();
$p->add(array('city' => 'London'));
$p->add(array('city' => 'NewYork'));

$p->run(function($items){
    $city = $items['city'];
    $pid = getmypid();
    echo "$pid $city payload\n";
});