<?php

function print_var($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function dump_var($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

error_reporting('E_ALL');
ini_set('display_errors', 1);

// Include the sphinx API class
require('sphinxapi.php');

$SphinxClient = new SphinxClient();
$SphinxClient->setServer("localhost", 9312);
$SphinxClient->setMatchMode(SPH_MATCH_ANY);
$SphinxClient->setMaxQueryTime(3);
$SphinxClient->setLimits(0,60);
//echo 'status'; dump_var($SphinxClient->status());

echo 'GetLastError'; dump_var($SphinxClient->GetLastError());

$result = $SphinxClient->query("is my",'test1');


echo 'result'; dump_var($SphinxClient->query("is my",'test1'));

echo 'GetLastError'; dump_var($SphinxClient->GetLastError());