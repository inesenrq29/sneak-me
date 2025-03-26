<?php
require_once __DIR__ . '/../Includes/db.php';

function addKeyword($name) {
    $dbh = getConnection();
    $req = "INSERT INTO keyword (name) VALUES(:name)";
    $stmt = $dbh->prepare($req);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    return $stmt->execute();
}

function addResponse($name) {
    $dbh = getConnection();
    $req = "INSERT INTO response (name) VALUES(:name)";
    $stmt = $dbh->prepare($req);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    return $stmt->execute();
}

function associate($keyword,$response) {
    $dbh = getConnection();
//récupérer les ids des deux tables
    $reqKeyword = "SELECT id FROM keyword WHERE name =:name";
    $reqResponse = "SELECT id FROM response WHERE name =:name";
    $stmtKeyword = $dbh->prepare($reqKeyword);
    $stmtResponse = $dbh->prepare($reqResponse);
    $stmtKeyword->bindValue(":name",$keyword, PDO::PARAM_STR);
    $stmtResponse->bindValue(":name",reqResponse, PDO::PARAM_STR);
    $stmtKeyword->execute();
    $stmtResponse->execute();
    $keywordId = $stmtKeyword->fetchColumn();
    $responseId = $stmtResponse->fetchColumn();
//vérifier si les IDS existent
    if(!$keywordId || $responseId) {
        return false;
    }
//insérer en évitant les doublons
    $req = "INSERT IGNORE INTO keyword_response (keyword_id, response_id) VALUES(:keyword_id,:response_id)";
    $stmt = $dbh->prepare($req)
    $stmt->bindValue(":keyword_id",$keywordId, PDO::PARAM_STR);
    $stmt->bindValue(":response_id",responseId, PDO::PARAM_STR);
    return $stmt->execute();
}