<?php
// Création d'un code aléatoire pour le captcha si il n'existe pas encore dans la session
if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = rand(10000, 99999);
}
$captcha = $_SESSION['captcha'];
?>

<div class="login-container">
    <div class="welcome-section">
        <img src="<?= URL ?>Public/images/logo-white.png" alt="SneakMe Logo" class="login-logo">
        <h2>Bienvenue sur SneakMe</h2>
        <p>Connectez-vous pour accéder à votre espace administrateur</p>
    </div>

    <form action="" method="post">
        <h1>Connexion</h1>

        <div class="form-group">
            <label for="username">Identifiant</label>
            <input type="text" name="username" id="username" required/>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required />
        </div>

        <div class="form-group">
            <label for="captcha">Captcha</label>
            <input type="text" name="captcha" id="captcha" required />
            <div class="captcha-container"><?php echo $captcha; ?></div>
        </div>

        <div class="form-group">
            <input type="hidden" name="honeypot" />
        </div>

        <input type="submit" value="Se connecter"/>

        <?php
        // Affichage de l'erreur si le captcha ou les identifiants sont incorrects
        if (isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
    </form>
</div>

