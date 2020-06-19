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
    <title>Samplaces</title>
</head>
<body>

    <header class="index-header">
        <img id="logo" src="img/logo-site.png" alt="samplaces">

        <nav>
            <h1>dê um rolê por são paulo sem sair de casa</h1>
            <h4>conheça (e compartilhe) os lugares favoritos através de um olhar pessoal e único de cada pedacinho da cidade!</h4>
            <a href="cadastro-user.php"><button class="botao-grande">cadastre-se</button></a>
            <a href="login.php"><p>ou faça login :)</p></a>
        </nav>
        
    </header>

    <main>
        <div class="conteudo exibir top home">
            <div class="bloco-top cidade">
                <div class="lista">
                    <h3>explore a cidade</h3>
                    <p>passeie pelas páginas <a href="exibir.php?recente=true">recente</a> e <a href="top.php">top</a> e conheça os lugares mais amados da cidade</p>
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


            <div class="bloco-top mundo">
                <div class="fav-outros posts">
                    <img src="img/exemplo2.png" alt="lugares favoritos">
                </div>
                
                <div class="lista">
                    <h3>compartilhe com o mundo</h3>
                    <p>crie uma conta e compartilhe seus lugares favoritos nos contando uma história curtinha sobre ele</p>
                </div>
            </div>


            <div class="bloco-top encontre">
                <div class="lista">
                    <h3>encontre seus amigos</h3>
                    <p>visite a seleção de lugares favoritos dos seus amigos e conheça ou relembre histórias :')</p>
                </div>

                <div class="fav-outros posts">
                    <img src="img/exemplo1.png" alt="amigos">
                </div>
            </div>

            <a id="b-home" href="cadastro-user.php"><button class="botao-grande">crie uma conta agora mesmo</button></a>

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

