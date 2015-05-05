<?php 

include 'myPDO.class.php';

myPDO::setConfiguration('mysql:host=syn-sgbd:3337;dbname=sinapps;charset=utf8', 'sinadmin', 'gh48LM@k2');

$pdo = myPDO::getInstance();