<body id="dashboard_body">
    <div class="main-content">     
        <div class="header">
            <h1 class="title">Dashboard</h1>
        </div>
      
        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Utilisateurs non admin</h3>
                <p><?= htmlspecialchars($nonAdminCount); ?></p>
            </div>
            <div class="card">
                <i class="fas fa-tags"></i>
                <h3>Mots-Clés</h3>
                <p><?= htmlspecialchars($keywordsCount); ?></p>
            </div>
            <div class="card">
                <i class="fas fa-comments"></i>
                <h3>Réponses</h3>
                <p><?= htmlspecialchars($responsesCount); ?></p>
            </div>
        </div>
        
        <div class="link-container">
            <a class="btn" href="<?= URL ?>chatbot">
                <i class="fas fa-arrow-left"></i> Retour à la gestion des mots-clés
            </a> 
        </div>
    </div> 
</body>
</html>
