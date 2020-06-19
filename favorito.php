<?php 

include("includes/functions.php");

session_start();

if($_GET['user']){
    // guarda o user solicitado
    $user = $_GET['user'];

    // carrega as informações do usuário em um array
    $perfil = carregaUser($user);
}
if($_GET['fav']){
    $curto = $_GET['fav'];

    $favorito = carregaTipoFavorito($curto);
}

$favcad = carregaFavUserTipo($perfil['user'], $favorito['id']);

if($favcad == false){
    $favcad = ['descricao' => 'Volte mais tarde, ao que tudo indica esse favorito ainda não foi cadastrado ):',
    'foto' => 'img/nao-tem.png',
    'lugar' => 'Oooops!'];
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
    <title><?= $favcad['lugar'] ?>, por <?= $perfil['user'] ?> | Samplaces</title>
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
        <div class="conteudo">

            <h3 style="color: <?= $favorito['cor'] ?>"><?= $favorito['nome'] ?></h3>
            <article class="favorito">
                
                <div class="imagem-grande">
                    <img src="<?= $favcad['foto'] ?>" alt="<?= $favcad['lugar'] ?>">
                </div>
                <div class="info">
                    <h4 style="color: <?= $favorito['cor'] ?>"><?= $favcad['lugar'] ?></h4>
                    <p><?= $favcad['descricao'] ?></p>
                    <div class="icones">
                        <a href="exibir.php?lugar=<?= $favcad['idlugar'] ?>&tipo=1">
                            <div id="fav">
                                <img src="img/favorito.png" alt="favorito">
                                <?php if(isset($favcad['idlugar'])){ ?>
                                <h6><?= quantFav($favcad['idlugar'], 1) ?></h6>
                                <?php } else { ?>
                                    <h6>0</h6>
                                <?php } ?>
                            </div>
                        </a>
                        <a href="exibir.php?lugar=<?= $favcad['idlugar'] ?>&tipo=2">
                            <div id="amigos">
                                <img src="img/amigos.png" alt="amigos">
                                <?php if(isset($favcad['idlugar'])){ ?>
                                <h6><?= quantFav($favcad['idlugar'], 2) ?></h6>
                                <?php } else { ?>
                                    <h6>0</h6>
                                <?php } ?>
                            </div>
                        </a>
                        <a href="exibir.php?lugar=<?= $favcad['idlugar'] ?>&tipo=3">
                            <div id="date">
                                <img src="img/date.png" alt="date">
                                <?php if(isset($favcad['idlugar'])){ ?>
                                <h6><?= quantFav($favcad['idlugar'], 3) ?></h6>
                                <?php } else { ?>
                                    <h6>0</h6>
                                <?php } ?>
                            </div>
                        </a>
                        <a href="exibir.php?lugar=<?= $favcad['idlugar'] ?>&tipo=4">
                            <div id="domingo">
                                <img src="img/domingo.png" alt="domingo">
                                <?php if(isset($favcad['idlugar'])){ ?>
                                <h6><?= quantFav($favcad['idlugar'], 4) ?></h6>
                                <?php } else { ?>
                                    <h6>0</h6>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                    <a href="exibir.php?lugar=<?= $favcad['idlugar'] ?>"><button class="botao-grande">passear</button></a>
                    <?php if(isset($_SESSION['user']) && $_SESSION['user'] == $user) { ?>
                    <a href="editar-fav.php?user=<?= $user ?>&fav=<?= $curto ?>"><button class="botao-grande" style="background-color: <?= $favorito['cor'] ?>">editar favorito</button></a>
                    <?php } ?>
                </div>
            </article>
        </div>

        <div class="usuario">
            <a href="perfil.php?user=<?= $user ?>">
                <img src= "<?= $perfil['foto'] ?>" alt= <?= $perfil['nome'] ?>>
                <h5><?= $perfil['nome'] ?></h5>
                <h6>@<?= $perfil['user'] ?></h6>
            </a>
            <p><?php if($perfil['bairro'] == "não mora em São Paulo" || $perfil['bairro'] == ""){
                        echo $perfil['bairro'];
                    } else{
                        echo $perfil['bairro'] . ", São Paulo";
                    }?></p>

            <nav class="fav-user">
                <ul>
                <?php if(carregaFavUserTipo($user, 1) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=favorito">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=favorito">
                    <?php } ?>
                    <li>lugar favorito ever</li></a>

                    <?php if(carregaFavUserTipo($user, 2) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=amigos">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=amigos">
                    <?php } ?>
                    <li>favorito para encontrar os amigos</li></a>

                    <?php if(carregaFavUserTipo($user, 3) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=date">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=date">
                    <?php } ?>
                    <li>favorito para um date</li></a>

                    <?php if(carregaFavUserTipo($user, 4) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=domingo">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=domingo">
                    <?php } ?>
                    <li>favorito de domingo</li></a>
                </ul>
            </nav>

            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == $perfil['user']){ ?>
                <nav class="menu-user">
                    <ul>
                        <a href="#"><li>salvos</li></a>
                        <a href="editar-user.php?user=<?= $perfil['user'] ?>"><li>configurações</li></a>
                        <a href="#"><li>sair</li></a>
                    </ul>
                </nav>
            <?php } else { 
                if(isset($_SESSION['id']) && verificaSeguir($_SESSION['id'], $perfil['id'])){?>
                <a href="seguir.php?user=<?= $user ?>&&action=excluir" id="a-botao">
                    <button class="botao-grande" style="background-color: #eb4100">deixar de seguir</button></a>
                <?php } else { ?>
                    <a href="seguir.php?user=<?= $user ?>" id="a-botao"><button class="botao-grande">seguir</button></a>
            <?php } } ?>
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