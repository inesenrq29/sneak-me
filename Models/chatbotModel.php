<?php
require_once __DIR__ . '/../Includes/db.php';

class ChatbotModel {

    public function getAllKeywordsAndResponses(): array
    {
        $pdo = getConnection();

        // Requête SQL pour récupérer les mots-clés, leurs réponses ainsi que leurs IDs respectifs
        $stmt = $pdo->query('
            SELECT
                k.id AS keyword_id,
                k.keyword_name,
                r.id AS response_id,
                r.response_name
            FROM keyword_response kr
            INNER JOIN keyword k ON kr.keyword_id = k.id
            INNER JOIN response r ON kr.response_id = r.id
        ');

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les résultats sous forme de tableau associatif
    }


    public function deleteKeyword($keyword_name): bool
    {
        $pdo = getConnection();
        $query = "DELETE FROM keyword WHERE keyword_name = :keyword_name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':keyword_name', $keyword_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addKeywordAndResponse($keyword, $response): array
    {
        $dbh = getConnection();
        try {
            $dbh->beginTransaction();

            // Mot-clé
            $stmt = $dbh->prepare("SELECT id FROM keyword WHERE keyword_name = :keyword");
            $stmt->execute([':keyword' => $keyword]);
            $kid = $stmt->fetchColumn();

            if (!$kid) {
                $stmt = $dbh->prepare("INSERT INTO keyword (keyword_name) VALUES (:keyword)");
                $stmt->execute([':keyword' => $keyword]);
                $kid = $dbh->lastInsertId();
            }

            // Réponse
            $stmt = $dbh->prepare("SELECT id FROM response WHERE response_name = :response");
            $stmt->execute([':response' => $response]);
            $rid = $stmt->fetchColumn();

            if (!$rid) {
                $stmt = $dbh->prepare("INSERT INTO response (response_name) VALUES (:response)");
                $stmt->execute([':response' => $response]);
                $rid = $dbh->lastInsertId();
            }

            // Association
            $stmt = $dbh->prepare("SELECT 1 FROM keyword_response WHERE keyword_id = :kid AND response_id = :rid");
            $stmt->execute([':kid' => $kid, ':rid' => $rid]);
            if ($stmt->fetchColumn()) {
                $dbh->commit();
                return ['association_exists' => true, 'association_created' => false];
            }

            $stmt = $dbh->prepare("INSERT INTO keyword_response (keyword_id, response_id) VALUES (:kid, :rid)");
            $stmt->execute([':kid' => $kid, ':rid' => $rid]);

            $dbh->commit();
            return ['association_exists' => false, 'association_created' => true];
        } catch (Exception $e) {
            $dbh->rollBack();
            return ['association_exists' => false, 'association_created' => false];
        }
    }


    public function updateKeyword($keyword_name,$keyword_id): bool
    {
        $dbh = getConnection();

        // Vérifier si le mot-clé existe déjà
        $checkQuery = "UPDATE keyword SET keyword_name=:keyword_name WHERE id=:keyword_id";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":keyword_name", $keyword_name, PDO::PARAM_STR);
        $checkStmt->bindValue(":keyword_id", $keyword_id, PDO::PARAM_INT);
        return $checkStmt->execute();
    }

    public function updateResponse($response_name,$response_id): bool
    {
        $dbh = getConnection();

        // Vérifier si le mot-clé existe déjà
        $checkQuery = "UPDATE response SET response_name=:response_name WHERE id=:response_id";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindValue(":response_name", $response_name, PDO::PARAM_STR);
        $checkStmt->bindValue(":response_id", $response_id, PDO::PARAM_INT);
        return $checkStmt->execute();
    }

}
?>

