<?php
$title = "Ajout de mot clé et réponse";

require_once(__DIR__ . '/../Includes/header.php');
require_once(__DIR__ . '/../Includes/db.php');
require_once(__DIR__ . '/../Models/chatbotModel.php');

$chatbotModel = new ChatbotModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
    try {
        $keyword_name = trim($_POST['keyword_name']);
        $response_name = trim($_POST['response_name']);

        // fonction pour ajouter un mot-clé
        $keywordSuccess = $chatbotModel->addKeyword($keyword_name);

        // fonction pour ajouter une réponse
        $responseSuccess = $chatbotModel->addResponse($response_name);

        if ($keywordSuccess && $responseSuccess) {
            // Tentative d'association
            $associationResult = $chatbotModel->associate($keyword_name, $response_name);

            if ($associationResult === "mot-clé déjà associé") {
                $errorMessage = "Le mot-clé est déjà associé à cette réponse.";
            } elseif ($associationResult) {
                $associationSuccess = true;
            } else {
                $associationSuccess = false;
            }
        } else {
            $associationSuccess = false;
        }
    } catch (Exception $exception) {
        $errorMessage = "Une erreur est survenue : " . $exception->getMessage();
    }
}
?>

<form method="post" action="">
    <div>
        <label for="keyword_name">Ajouter un/des mot(s)-clé(s): </label>
        <input type="text" name="keyword_name" id="keyword_name" required />
    </div>
    <div>
        <label for="response_name">Ajouter une réponse associée: </label>
        <input type="text" name="response_name" id="response_name" required />
    </div>
    <button type="submit">Ajouter</button>
</form>

<?php if (isset($associationSuccess) && $associationSuccess): ?>
    <div class="container-md">
        <div class="alert alert-success" role="alert">
            <p>Le mot-clé et la réponse ont bien été ajoutés et associés.</p>
            <button type="button" class="btn-close" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="alert alert-danger" role="alert">
            <p>Erreur: <?= htmlspecialchars($errorMessage) ?></p>
            <button type="button" class="btn-close" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-close").forEach(button => {
            button.addEventListener("click", function () {
                this.parentElement.style.display = "none";
            });
        });
    });
</script>

<a href="<?= URL ?>chatbot"><button>Retour au chat</button></a>
