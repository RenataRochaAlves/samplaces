<?php 

include("includes/functions.php");

session_start();

if($_GET['user']){
    // guarda o user solicitado
    $user = $_GET['user'];

    // carrega as informações do usuário em um array
    $perfil = carregaUser($user);
}

if($_SESSION){
    seguir($_SESSION['id'], $perfil['id']);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Seguir <?= $perfil['nome'] ?> | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <?php if($_SESSION) {?>
                    <a href="#"><li>amigos</li></a>
                    <a href="perfil.php?user=<?= $_SESSION['user'] ?>"><li>perfil</li></a>
                    <a href="logout.php"><li id="logout">logout</li></a>
                <?php } else { ?>
                    <a href="login.php"><li id="logout">junte-se a nós! faça login</li></a>
                <?php } ?>
            </ul>
            <div class="busca">
                <input type="text" name="busca" id="busca" value="">
                <button type="submit"><img src="img/busca.png" alt="buscar"></button>
            </div>
        </nav>
    </header>

    <main>
        <div class="conteudo seguir">
            <?php if($_SESSION){ ?>
                <div class="imagens">
                    <img src="<?= $_SESSION['foto'] ?>" alt="<?= $_SESSION['nome'] ?>">
                    <img src="img/mais.png" alt="mais" id="mais">
                    <img src="<?= $perfil['foto'] ?>" alt="<?= $perfil['nome'] ?>">
                </div>
                <h3>Eba!</h3>
                <p>agora você está seguindo <?= $perfil['nome'] ?></p>
                <a href="perfil.php?user=<?= $user ?>"><button class="botao-grande">ir para o perfil</button></a>
            <?php } else { ?>
                <h3>Oooops!</h3>
                <p>você precisa fazer login para seguir <?= $perfil['nome'] ?></p>
                <a href="login.php"><button class="botao-grande">fazer login</button></a>
            <?php } ?>
                
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
</body>
</html>