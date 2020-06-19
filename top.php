<?php 

include("includes/functions.php");

session_start();

if(isset($_SESSION['user'])){
    // guarda o user solicitado
    $user = $_SESSION['user'];

    // carrega as informações do usuário em um array
    $perfil = carregaUser($user);
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

$top = topLugares();
$favorito = topLugaresTipo(1);
$amigos = topLugaresTipo(2);
$date = topLugaresTipo(3);
$domingo = topLugaresTipo(4);

$posts = exibirTopPosts($top);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Top | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
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
        <div class="conteudo exibir top">
            <div class="bloco-top">
                <div class="lista">
                    <h3 id="topo">top do topo</h3>
                    <article class="favorito topo">
                            <ol>
                                <?php foreach($top as $value): ?>
                                    <a href="exibir.php?lugar=<?= $value['id'] ?>">
                                        <li><?= $value['lugar'] ?></li>
                                    </a>
                                <?php endforeach ?>
                            </ol>
                    </article>

                    <h3>lugares favoritos ever</h3>
                    <article class="favorito">
                            <ol>
                                <?php foreach($favorito as $value): ?>
                                    <a href="exibir.php?lugar=<?= $value['id'] ?>&tipo=1">
                                        <li><?= $value['lugar'] ?></li>
                                    </a>
                                <?php endforeach ?>
                            </ol>
                    </article>
                </div>

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
            

            <div class="fav-outros">
                <div class="fav-amigos">
                    <h5>encontrar os amigos</h5>
                    <ol>
                        <?php foreach($amigos as $value): ?>
                            <a href="exibir.php?lugar=<?= $value['id'] ?>&tipo=2">
                                <li><?= $value['lugar'] ?></li>
                            </a>
                        <?php endforeach ?>
                    </ol>
                </div>
                <div class="fav-date">
                    <h5>favorito para um date</h5>
                    <ol>
                        <?php foreach($date as $value): ?>
                            <a href="exibir.php?lugar=<?= $value['id'] ?>&tipo=3">
                                <li><?= $value['lugar'] ?></li>
                            </a>
                        <?php endforeach ?>
                    </ol>
                </div>
                <div class="fav-domingo">
                    <h5>favorito de domingo</h5>
                    <ol>
                        <?php foreach($domingo as $value): ?>
                            <a href="exibir.php?lugar=<?= $value['id'] ?>&tipo=4">
                                <li><?= $value['lugar'] ?></li>
                            </a>
                        <?php endforeach ?>
                    </ol>
                </div>
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