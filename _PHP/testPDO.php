<?php

include 'myPDO.class.php';

myPDO::setConfiguration('mysql:host=mysql;dbname=sinapps;charset=utf8', 'root', '');

$pdo = myPDO::getInstance() ;

$stmt = $pdo->prepare(<<<SQL
    SELECT *
    FROM divers
SQL
);

$stmt->execute() ;

while (($ligne = $stmt->fetch()) !== false) {
    echo "<p>{$ligne['name']}\n" ;
}