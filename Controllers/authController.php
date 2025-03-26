<?php

class AuthController {

    // Méthode pour afficher la page de connexion et gérer la soumission du formulaire
    public function login() {
        // Vérifie si l'utilisateur est déjà connecté
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
            // Redirige vers le tableau de bord si déjà connecté
            header('Location: ' . URL . 'dashboard');
            exit();
        }

        // Si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // pot de miel
            if (!empty($_POST['honeypot'])){
                //si le champ est rempli, c'est probablement un bot
                header('HTTP/1.1 403 Forbidden');
                exit('Accès interdit');
               }                
            // Récupérer les données du formulaire
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Vérification des informations de connexion
            if ($username === 'admin' && $password === '$2y$10$UOC70iO80WD/i3J9Q2a0me51OTxcRPufkLvaOQ0YMcaOhUHmPf1WC') {  
                // Authentification réussie
                $_SESSION['admin'] = true; // Définir une session pour l'utilisateur
                header('Location: ' . URL . 'dashboard');  // Redirige vers le tableau de bord
                exit();
            } else {
                // Authentification échouée
                $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
                header('Location: ' . URL . 'login');  // Redirige vers la page de login avec un message d'erreur
                exit();
            }
        }

        // Afficher la vue de connexion si ce n'est pas une soumission de formulaire
        include __DIR__ . '/../Views/login.php'; 
    }

    // Méthode pour gérer la déconnexion
    public function logout() {
        // Détruire toutes les sessions
        session_unset();
        session_destroy();

        // Rediriger vers la page de connexion
        header('Location: ' . URL . 'login');
        exit();
    }

    // Méthode pour afficher la page de tableau de bord
    public function dashboard() {
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de login
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            header('Location: ' . URL . 'login');
            exit();
        }

        // Afficher la vue du tableau de bord
        include __DIR__ . '/../Views/dashboard.php'; 
    }
}


// admin $2y$10$UOC70iO80WD/i3J9Q2a0me51OTxcRPufkLvaOQ0YMcaOhUHmPf1WC
?>

