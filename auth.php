<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: geopulse.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GeoPulse Live</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div claas = "auth-container">
        <h1>GeoPulse Live</h1>
        <p>Bienvenue sur la plateforme</p>

        <div class="switch-buttons">
            <button onclick="showForm('login')">Connexion</button>
            <button onclick="showForm('register')">Insciption</button>
        </div>

        <?php if(isset($_GET['error'])):?>
            <p class="error">
                <?php
                if($_GET['error'] === 'invalid') echo "Email ou mot de passe incorrect.";
                if($_GET['error'] === 'exists') echo "Cet email existe déjà.";
                if($_GET['error'] === 'empty') echo "Veuillez remplir tous les champs.";
                ?>
            </p>
        <?php endif; ?>

        <?php if(isset($_GET['success']) && $_GET['success'] === 'registered') : ?>
            <p class="success">Inscription réussie. Vous pouvez maintenant vous connecter.</p>
        <?php endif; ?>

        <div id="login-form" class="form-box">
            <h2>Connexion</h2>
            <form action="process_login.php" method="POST">
                <input type="email" name="email" placeholder="Votre email" required><br>
                <input type="password" name="password" placeholder="Votre mot de passe" required><br>
                <button type="submit">Se connecter</button>
            </form>
        </div>

        <div id="register-form" class="form-box hidden">
            <h2>Inscription</h2>
            <form action="process_register.php" method="POST">
                <input type="text" name="nom" placeholder="Votre nom" required><br>
                <input type="text" name="prenom" placeholder="Votre prenom" required><br>
                <input type="email" name="email" placeholder="Votre email" required><br>
                <input type="password" name="password" placeholder="Votre mot de passe" required><br>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

    <script>
        function showForm(type){
            const loginForm = document.getElementById("login-form");
            const registerForm = document.getElementById("register-form");

            if(type === 'login'){
                loginForm.classList.remove("hidden");
                registerForm.classList.add("hidden");
            }else{
                registerForm.classList.remove("hidden");
                loginForm.classList.add("hidden");
            }
        }
        
        const params = new URLSearchParams(window.location.search);
        if (params.get('show') === 'register') {
            showForm('register');
        }
    </script>
</body>
</html>