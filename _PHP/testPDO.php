<?php

include 'myPDO.include.php';

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