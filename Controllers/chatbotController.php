<?php

require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Models/chatbotModel.php';

class ChatbotController {

    public function read() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once __DIR__ . "/../Includes/header.php";

        $chatbotModel = new ChatbotModel();
        $keywordsAndResponses = $chatbotModel->getAllKeywordsAndResponses();


        include __DIR__ . '/../Views/chatbot.php';
    }

    public function deleteKeyword() {
        // Vérifier qu'un mot-clé est passé en POST
        if (isset($_POST['keyword_name'])) {
            $keyword_name = $_POST['keyword_name'];
            $chatbotModel = new ChatbotModel();
            $chatbotModel->deleteKeyword($keyword_name);
            header("Location: " . URL . "chatbot");
            exit();
        }
    }

    public function addChatKeyword() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once __DIR__ . "/../Includes/header.php";

        $message = "";
        $type = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
            $keyword_name = strtolower(trim($_POST['keyword_name']));
            $response_name = strtolower(trim($_POST['response_name']));

            $chatbotModel = new ChatbotModel();

            // Fusion : ajoute ou récupère les IDs existants
            $result = $chatbotModel->addKeywordAndResponse($keyword_name, $response_name);

            if ($result['association_created']) {
                $type = "success";
                $message = "Mot-clé et réponse associés avec succès.";
            } elseif ($result['association_exists']) {
                $type = "info";
                $message = "Ce mot-clé et cette réponse sont déjà associés.";
            } else {
                $type = "error";
                $message = "Une erreur est survenue lors de l'ajout.";
            }
        }

        include __DIR__ . '/../Views/chatbotAdd.php';
    }



    public function updateKeyword() {
        require_once __DIR__ . "/../Includes/head.php";
        require_once(__DIR__ . '/../Includes/header.php');

        if (!empty($_POST['keyword_name']) && !empty($_POST['response_name']) &&
            !empty($_POST['keyword_id']) && !empty($_POST['response_id'])) {

            // Conversion en minuscules
            $keyword_name = strtolower($_POST['keyword_name']);
            $response_name = strtolower($_POST['response_name']);
            $keyword_id = intval($_POST['keyword_id']);
            $response_id = intval($_POST['response_id']);

            $chatbotModel = new ChatbotModel();

            $keywordUpdated = $chatbotModel->updateKeyword($keyword_name, $keyword_id);
            $responseUpdated = $chatbotModel->updateResponse($response_name, $response_id);
        }

        include __DIR__ . '/../Views/chatbotUpdate.php';
    }



}


?>


