<?php
function query_from_database($query, $array) {
    $db = new PDO("sqlite:../datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $res=$db->prepare($query);
    $res->execute($array);
    if ($res)
        $res->setFetchMode(PDO::FETCH_NAMED);
    return $res;
}

