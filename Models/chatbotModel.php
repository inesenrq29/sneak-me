<?php
require_once __DIR__ . '/../Includes/db.php'; // Inclusion du fichier de connexion

class ChatbotModel {

    public function getAllKeywordsAndResponses() {
        
        $pdo = getConnection(); 

        // Requête SQL pour récupérer les mots-clés et leurs réponses
        $stmt = $pdo->query('
            SELECT keyword_name, response_name
            FROM keyword_response
            INNER JOIN keyword ON keyword_response.keyword_id = keyword.id
            INNER JOIN response ON keyword_response.response_id = response.id
        ');

        return $stmt->fetchAll(); // Retourne les résultats sous forme de tableau associatif
    }

   public function addKeyword($keyword_name) {
       $dbh = getConnection();

       // Vérifier si le mot-clé existe déjà
       $checkQuery = "SELECT id FROM keyword WHERE keyword_name = :keyword_name";
       $checkStmt = $dbh->prepare($checkQuery);
       $checkStmt->bindValue(":keyword_name", $keyword_name, PDO::PARAM_STR);
       $checkStmt->execute();

       if ($checkStmt->fetchColumn()) {
           return true; // Si le mot-clé existe déjà, on ne fait rien
       }

       // Insérer le mot-clé s'il n'existe pas
       $req = "INSERT INTO keyword (keyword_name) VALUES(:keyword_name)";
       $stmt = $dbh->prepare($req);
       $stmt->bindValue(":keyword_name", $keyword_name, PDO::PARAM_STR);
       return $stmt->execute();
   }

    public function addResponse($response_name) {
        $dbh = getConnection();

        // Vérifier si la réponse existe déjà
        $checkQuery = "SELECT id FROM response WHERE response_name = :response_name";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":response_name", $response_name, PDO::PARAM_STR);
        $checkStmt->execute();

        $existingId = $checkStmt->fetchColumn();
        if ($existingId) {
            return $existingId; // Retourne l'ID existant pour éviter les doublons
        }

        // Insérer uniquement si elle n'existe pas
        $req = "INSERT INTO response (response_name) VALUES(:response_name)";
        $stmt = $dbh->prepare($req);
        $stmt->bindValue(":response_name", $response_name, PDO::PARAM_STR);
        $stmt->execute();

        return $dbh->lastInsertId(); // Retourner l'ID de la réponse insérée
    }


    public function associate($keyword_name, $response_name) {
        $dbh = getConnection();

        // Récupérer l'ID du mot-clé
        $stmtKeyword = $dbh->prepare("SELECT id FROM keyword WHERE keyword_name = :keyword_name");
        $stmtKeyword->bindValue(":keyword_name", $keyword_name, PDO::PARAM_STR);
        $stmtKeyword->execute();
        $keywordId = $stmtKeyword->fetchColumn();

        // Récupérer l'ID de la réponse
        $stmtResponse = $dbh->prepare("SELECT id FROM response WHERE response_name = :response_name");
        $stmtResponse->bindValue(":response_name", $response_name, PDO::PARAM_STR);
        $stmtResponse->execute();
        $responseId = $stmtResponse->fetchColumn();

        // Vérification que les IDs existent
        if (!$keywordId || !$responseId) {
            return false;
        }


        // Associer les deux sans doublons
        $req = "INSERT IGNORE INTO keyword_response (keyword_id, response_id) VALUES(:keyword_id, :response_id)";
        $stmt = $dbh->prepare($req);
        $stmt->bindValue(":keyword_id", $keywordId, PDO::PARAM_INT);
        $stmt->bindValue(":response_id", $responseId, PDO::PARAM_INT);

        return $stmt->execute();
    }


}
?>

