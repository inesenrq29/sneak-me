<?php

require_once __DIR__ . "/../Models/dashboardModel.php";

class DashboardController {

    public function dashboard() {
        $dashboardModel = new DashboardModel();
        $nonAdminCount = $dashboardModel->countNonAdminUsers();
        $keywordsCount = $dashboardModel->countKeyword();
        $responsesCount = $dashboardModel->countResponse();

        // Si l'utilisateur n'est pas connecté, rediriger vers la page de login
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            header('Location: ' . URL . 'login');
            exit();
        }

        // Afficher la vue du tableau de bord
        include __DIR__ . '/../Views/dashboard.php'; 
    }

    public function index() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            // Redirige vers la page de connexion si non authentifié
            header('Location: ' . URL . 'login');
            exit();
        }

        include __DIR__ . '/../Views/dashboard.php'; 
    }


}

?>
