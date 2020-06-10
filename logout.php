<?php 

session_start();

unset($_SESSION['nome']);
unset($_SESSION['user']);
unset($_SESSION['foto']);
unset($_SESSION['email']);

include("includes/functions.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title>Logout | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <a href="login.php"><li id="logout">junte-se a nós! faça login</li></a>
            </ul>
        </nav>
    </header>

    <main class="main-logout">
        <div class="logout">
            <h3>até mais!</h3>
            <p>logout efetuado com sucesso</p>
            <a href="login.php"><button class="botao-grande">fazer login</button></a>
            <a href="#"><button class="botao-grande">ir para a home</button></a>
        </div> 
    </main>

    <footer>
        <img src="img/logo-branco.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <a href="#"><li>amigos</li></a>
            </ul>
        </nav>
        <a href="https://github.com/RenataRochaAlves/samplaces" target="_blank">
            <img src="img/github.png" alt="GitHub">
        </a>     
    </footer>


    <script>
        document.getElementById("foto").onchange = (evt) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("foto-carregada").src = e.target.result;
            };
            reader.readAsDataURL(evt.target.files[0]);
        };
    </script>
</body>
</html>