<?php
$title = "Modification de mot-clé et réponse";

$chatbotModel = new ChatbotModel();
$keywordsAndResponses = $chatbotModel->getAllKeywordsAndResponses();

// Récupérer les IDs envoyés via POST
$keyword_id = isset($_POST['keyword_id']) ? intval($_POST['keyword_id']) : 0;
$response_id = isset($_POST['response_id']) ? intval($_POST['response_id']) : 0;

$keyword_name = "";
$response_name = "";

// Si le formulaire a été soumis, mettre à jour la base de données
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
    try {
        $keyword_name = trim($_POST['keyword_name']);
        $response_name = trim($_POST['response_name']);

        // Mise à jour du mot-clé et de la réponse
        $keywordUpdated = $chatbotModel->updateKeyword($keyword_name, $keyword_id);
        $responseUpdated = $chatbotModel->updateResponse($response_name, $response_id);

        if ($keywordUpdated && $responseUpdated) {
            $updateSuccess = true;
        } else {
            $updateSuccess = false;
        }
    } catch (Exception $exception) {
        $errorMessage = "Une erreur est survenue : " . $exception->getMessage();
    }
}

// Récupérer les valeurs actuelles
foreach ($keywordsAndResponses as $row) {
    if ($row['keyword_id'] == $keyword_id && $row['response_id'] == $response_id) {
        $keyword_name = htmlspecialchars($row['keyword_name']);
        $response_name = htmlspecialchars($row['response_name']);
        break;
    }
}
?>


<h2>Modifier un mot-clé et sa réponse</h2>

<p><strong>ID Mot-clé :</strong> <?= $keyword_id ?></p>
<p><strong>Mot-clé :</strong> <?= $keyword_name ?></p>
<p><strong>ID Réponse :</strong> <?= $response_id ?></p>
<p><strong>Réponse :</strong> <?= $response_name ?></p>

<form method="post" action="">
    <input type="hidden" name="keyword_id" value="<?= $keyword_id ?>" />
    <input type="hidden" name="response_id" value="<?= $response_id ?>" />

    <div>
        <label for="keyword_name">Modifier le mot-clé :</label>
        <input type="text" name="keyword_name" id="keyword_name" value="<?= $keyword_name ?>" required />
    </div>
    <div>
        <label for="response_name">Modifier la réponse associée :</label>
        <input type="text" name="response_name" id="response_name" value="<?= $response_name ?>" required />
    </div>
    <button type="submit">Modifier</button>
</form>

<?php if (isset($updateSuccess) && $updateSuccess): ?>
    <div class="container-md">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>Le mot-clé et la réponse ont bien été modifiés.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Erreur: <?= htmlspecialchars($errorMessage) ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.btn-close').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert').remove();
            });
        });
    });
</script>

<a href="<?= URL ?>chatbot"><button>Retour au chat</button></a>
