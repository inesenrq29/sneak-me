<?php
$title = "Ajout de mot clé et réponse";

$chatbotModel = new ChatbotModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['keyword_name']) && !empty($_POST['response_name'])) {
    try {
        $keyword_name = trim($_POST['keyword_name']);
        $response_name = trim($_POST['response_name']);

        // on ajoute le mot-clé et la réponse
        $keywordSuccess = $chatbotModel->addKeyword($keyword_name);
        $responseSuccess = $chatbotModel->addResponse($response_name);

        // on vérifie l'association
        $associationResult = $chatbotModel->associate($keyword_name, $response_name);
        
        if ($associationResult === "Mot-clé déjà associé.") {
            throw new Exception("Le mot-clé est déjà associé à cette réponse.");
        } elseif (!$associationResult) {
            throw new Exception("Erreur lors de l'association du mot-clé et de la réponse.");
        }

        $successMessage = "Le mot-clé '$keyword_name' et la réponse ont été ajoutés et associés avec succès.";
        
    } catch (Exception $exception) {
        $errorMessage = $exception->getMessage();
    }
}
?>

<h2 class="title-add">Ajouter un mot-clé et sa réponse</h2>
<div class="form-container">
    <form method="post" action="">
        <div class="form-group">
            <label for="keyword_name">Ajouter un/des mot(s)-clé(s): </label>
            <input type="text" name="keyword_name" id="keyword_name" required />
        </div>
        <div class="form-group">
            <label for="response_name">Ajouter une réponse associée: </label>
            <input type="text" name="response_name" id="response_name" required />
        </div>
        <button type="submit" class="submit-btn">Ajouter</button>
    </form>
</div>

<?php if (isset($successMessage)): ?>
    <div class="container-md">
        <div class="message success alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($successMessage) ?>
            <button type="button" class="close-btn btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
        </div>
    </div>
<?php elseif (isset($errorMessage)): ?>
    <div class="container-md">
        <div class="message error alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
            <button type="button" class="close-btn btn-close" data-bs-dismiss="alert" aria-label="Fermer">Fermer</button>
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

<a class="link-button" href="<?= URL ?>chatbot"><button class="backchat"><i class="fas fa-arrow-left"></i> Retour au chat</button></a>
