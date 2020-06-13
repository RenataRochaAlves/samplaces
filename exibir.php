<?php 

include("includes/functions.php");

session_start();


if($_GET['lugar']){
    $lugar = $_GET['lugar'];

    $posts = exibirLugar($lugar);
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?= $posts[0]['nome'] ?> | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <?php if(isset($_SESSION['user'])) {?>
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
        <div class="conteudo">

            <h3><?= $posts[0]['nome'] ?></h3>
            

            <div class="fav-outros">
                <?php foreach($posts as $post): ?>
                <div>
                    <a href="favorito.php?user=<?= $post['user'] ?>&fav=<?= $post['tipo'] ?>">
                        <img src="<?= $post['foto'] ?>" alt="<?= $post['nome'] ?>, por @<?= $post['user'] ?>">
                    </a>
                    <h6><?= $post['nome'] ?></h6>
                    <div class="user-post">
                        <a href="perfil.php?user=<?= $post['user'] ?>">
                            <img src="<?= $post['foto_user'] ?>" alt="<?= $post['user'] ?>">
                            <h5>@<?= $post['user'] ?></h5>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
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