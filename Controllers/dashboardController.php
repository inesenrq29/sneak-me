<?php

class DashboardController {

    public function index() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            // Redirige vers la page de connexion si non authentifié
            header('Location: ' . URL . 'login');
            exit();
        }

        // Afficher la vue du tableau de bord
        include __DIR__ . '/../Views/dashboard.php'; 
    }
}

?>
