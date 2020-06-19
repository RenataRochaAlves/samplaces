<?php 

include("includes/functions.php");

session_start();


if(isset($_GET['lugar'])){
    $lugar = $_GET['lugar'];

    $posts = exibirLugar($lugar);

    $nome = $posts[0]['nome'];

    if(isset($_GET['tipo'])){
        $tipo = $_GET['tipo'];

        $posts = exibirLugarTipo($lugar, $tipo);
    }
}

if(isset($_SESSION['id']) && isset($_SESSION['user'])){
    $perfil = carregaUser($_SESSION['user']);

    if(isset($_GET['amigos'])){
        $idUser = $_SESSION['id'];

        $posts = exibirLugarAmigos($idUser);

        $amigos = exibirSeguindo($idUser);

        $nome = "Amigos";
    }
}

if(isset($_GET['recente'])) {
    $posts = exibirRecente();

    $nome = "Recentes";
}

$erro = true;

// realizando buscas
if(isset($_POST['busca'])){

    
    
    $buscaUser = buscaUser($_POST['busca']);
    $buscaLugar = buscaLugar($_POST['busca']);

    if(is_array($buscaLugar)){
        $endereco = 'exibir.php?lugar='.$buscaLugar['id'];
    }
    if(is_array($buscaUser)){
        $endereco = 'perfil.php?user='.$buscaUser['user'];
    }
    if(is_array($buscaLugar) == false && is_array($buscaUser) == false){
        $erro = false;
    } else {
        header("location: $endereco");
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?= $nome ?> | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="top.php"><li>top</li></a>
                <a href="exibir.php?recente=true"><li>recentes</li></a>
                <?php if(isset($_SESSION['user'])) {?>
                    <a href="exibir.php?amigos=true"><li>amigos</li></a>
                    <a href="perfil.php?user=<?= $_SESSION['user'] ?>"><li>perfil</li></a>
                    <a href="logout.php"><li id="logout">logout</li></a>
                <?php } else { ?>
                    <a href="login.php"><li id="logout">junte-se a nós! faça login</li></a>
                <?php } ?>
            </ul>
            <div class="busca">
                <form method="POST">
                    <input type="text" name="busca" id="busca" value="<?= ($erro? '' : 'nenhum resultado encontrado ):')?>">
                    <button type="submit"><img src="img/busca.png" alt="buscar"></button>
                </form>
            </div>
        </nav>
    </header>

    <main>
        <div class="conteudo exibir">

            <?php if(isset($_GET['amigos']) && isset($_SESSION['id'])) { ?>
                <h3>amigos</h3>
                <div class="amigos">
                    <?php foreach($amigos as $amigo): ?>
                        <a href="perfil.php?user=<?= $amigo['user'] ?>">
                            <div class="amigo">
                                <img src="<?= $amigo['foto'] ?>" alt="<?= $amigo['nome'] ?>">
                                <h5><?= $amigo['nome'] ?></h5>
                                <p>@<?= $amigo['user'] ?></p>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
                <h3>últimos favoritos</h3>   
            <?php } if(isset($_GET['recente'])) {?>
                <h3>recentes</h3>
            <?php } if(isset($_GET['lugar'])) {?>
                <h3><?= $posts[0]['nome'] ?></h3>
            <?php } ?>
            

            <div class="fav-outros posts">
                <?php foreach($posts as $post): ?>
                <div class="post">
                    <a href="favorito.php?user=<?= $post['user'] ?>&fav=<?= $post['tipo'] ?>">
                        <img src="<?= $post['foto'] ?>" alt="<?= $post['nome'] ?>, por @<?= $post['user'] ?>">
                    </a>
                    <div class="tipo">
                        <h6><?= $post['nome'] ?></h6>
                        <a href="exibir.php?lugar=<?= $post['lugar_id'] ?>&tipo=<?= $post['id_tipo'] ?>">
                            <img src="img/<?= $post['tipo'] ?>.png" alt="<?= $post['tipo'] ?>">
                        </a>
                    </div>
                    <div class="user-post">
                        <a href="perfil.php?user=<?= $post['user'] ?>">
                            <img  src="<?= $post['foto_user'] ?>" alt="<?= $post['user'] ?>">
                            <h5>@<?= $post['user'] ?></h5>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
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