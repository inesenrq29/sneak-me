<?php
require_once __DIR__ . '/../Includes/db.php';

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

    public function deleteKeyword($keyword_name) {
        $pdo = getConnection();
        $query = "DELETE FROM keyword WHERE keyword_name = :keyword_name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':keyword_name', $keyword_name, PDO::PARAM_STR);
        return $stmt->execute();
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

        try {
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
                throw new Exception("Le mot-clé ou la réponse n'a pas été trouvé.");
            }

            // Vérifier si l'association existe déjà
            $checkAssociationStmt = $dbh->prepare("SELECT 1 FROM keyword_response WHERE keyword_id = :keyword_id AND response_id = :response_id");
            $checkAssociationStmt->bindValue(":keyword_id", $keywordId, PDO::PARAM_INT);
            $checkAssociationStmt->bindValue(":response_id", $responseId, PDO::PARAM_INT);
            $checkAssociationStmt->execute();
            if ($checkAssociationStmt->fetchColumn()) {
                throw new Exception("Mot-clé déjà associé.");
            }

            // Associer sans doublon
            $stmt = $dbh->prepare("INSERT INTO keyword_response (keyword_id, response_id) VALUES(:keyword_id, :response_id)");
            $stmt->bindValue(":keyword_id", $keywordId, PDO::PARAM_INT);
            $stmt->bindValue(":response_id", $responseId, PDO::PARAM_INT);
            $stmt->execute();

            return true; // Si tout se passe bien
        } catch (Exception $e) {
            // Retourner l'erreur de l'exception
            return $e->getMessage();
        }
    }
}
?>

