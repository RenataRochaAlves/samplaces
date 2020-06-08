<?php 

include("includes/functions.php");

session_start();

if($_GET['user']){
    // guarda o user solicitado
    $user = $_GET['user'];

    // carrega as informações do usuário em um array
    $perfil = carregaUser($user);
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?= $perfil['nome'] ?> | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <a href="#"><li>amigos</li></a>
                <a href="#"><li id="logout">logout</li></a>
            </ul>
            <div class="busca">
                <input type="text" name="busca" id="busca" value="">
                <button type="submit"><img src="img/busca.png" alt="buscar"></button>
            </div>
        </nav>
    </header>

    <main>
        <div class="conteudo">

            <h3>lugar favorito ever</h3>
            <article class="favorito">
                
                <div class="imagem-grande">
                    <img src="img/places/martinelli.jpg" alt="Martinelli">
                </div>
                <div class="info">
                    <h4>Lorem ipsum dolor</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat nulla in, qui 
                    atque aut minus sint incidunt architecto molestiae rerum suscipit minima, fugiat hic 
                    inventore, sunt voluptatibus voluptates praesentium error?</p>
                    <div class="icones">
                        <a href="#">
                            <div id="fav">
                                <img src="img/favorito.png" alt="favorito">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="amigos">
                                <img src="img/amigos.png" alt="amigos">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="date">
                                <img src="img/date.png" alt="date">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="domingo">
                                <img src="img/domingo.png" alt="domingo">
                                <h6>368</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div id="salvo">
                                <img src="img/salvo.png" alt="salvo">
                                <h6>368</h6>
                            </div>
                        </a>
                    </div>
                    <a href="#"><button class="botao-grande">passear</button></a>
                </div>
            </article>

            <div class="fav-outros">
                <div class="fav-amigos">
                    <h5>encontrar os amigos</h5>
                    <a href="#">
                        <img src="img/places/pe-na-porta.jpg" alt="pé na porta">
                        <h6>Lorem ipsum dolor</h6>
                        <button>ver mais   >>></button>
                    </a>
                </div>
                <div class="fav-date">
                    <h5>favorito para um date</h5>
                    <a href="#">
                        <img src="img/places/praca-por-do-sol.jpg" alt="praça pôr-do-sol">
                        <h6>Lorem ipsum dolor</h6>
                        <button>ver mais   >>></button>
                    </a>
                </div>
                <div class="fav-domingo">
                    <h5>favorito de domingo</h5>
                    <a href="#">
                        <img src="img/places/paulista.jpg" alt="avenida paulista">
                        <h6>Lorem ipsum dolor</h6>
                        <button>ver mais   >>></button>
                    </a>
                </div>
            </div>
        </div>

        <div class="usuario">
            <img src= "<?= $perfil['foto'] ?>" alt= <?= $perfil['nome'] ?>>
            <h5><?= $perfil['nome'] ?></h5>
            <h6>@<?= $perfil['user'] ?></h6>
            <p><?php if($perfil['bairro'] == "não mora em São Paulo" || $perfil['bairro'] == ""){
                        echo $perfil['bairro'];
                    } else{
                        echo $perfil['bairro'] . ", São Paulo";
                    }?></p>

            <nav class="fav-user">
                <ul>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=favorito"><li>lugar favorito ever</li></a>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=amigos"><li>favorito para encontrar os amigos</li></a>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=date"><li>favorito para um date</li></a>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=domingo"><li>favorito de domingo</li></a>
                </ul>
            </nav>

            <?php if($_SESSION && $_SESSION['user'] == $perfil['user']){ ?>
                <nav class="menu-user">
                    <ul>
                        <a href="#"><li>salvos</li></a>
                        <a href="editar-user.php?user=<?= $perfil['user'] ?>"><li>configurações</li></a>
                        <a href="#"><li>sair</li></a>
                    </ul>
                </nav>
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