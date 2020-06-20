<?php 

include("includes/functions.php");

session_start();

if($_GET['user']){
    // guarda o user solicitado
    $user = $_GET['user'];

    // carrega as informações do usuário em um array
    $perfil = carregaUser($user);
}

if(isset($_SESSION['user']) && isset($_GET['action']) == false){
    seguir($_SESSION['id'], $perfil['id']);
}

if(isset($_GET['action']) && $_GET['action'] == "excluir"){
    excluirSeguir($_SESSION['id'], $perfil['id']);
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
    <title>Seguir <?= $perfil['nome'] ?> | Samplaces</title>
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

    <main class="main-logout">
        <div class="conteudo seguir">
            <?php if(isset($_SESSION['user']) && isset($_GET['action']) == false){ ?>
                <div class="imagens">
                    <img src="<?= $_SESSION['foto'] ?>" alt="<?= $_SESSION['nome'] ?>">
                    <img src="img/mais.png" alt="mais" id="mais">
                    <img src="<?= $perfil['foto'] ?>" alt="<?= $perfil['nome'] ?>">
                </div>
                <h3>Eba!</h3>
                <p>agora você está seguindo <?= $perfil['nome'] ?></p>
                <a href="perfil.php?user=<?= $user ?>"><button class="botao-grande">ir para o perfil</button></a>
            <?php } if(isset($_SESSION['user']) == false){ ?>
                <h3>Oooops!</h3>
                <p>você precisa fazer login para seguir <?= $perfil['nome'] ?></p>
                <a href="login.php"><button class="botao-grande">fazer login</button></a>
            <?php } if(isset($_GET['action']) && $_GET['action'] == "excluir"){ ?>
                <h3>Poxa ):</h3>
                <p>você deixou de seguir <?= $perfil['nome'] ?></p>
                <a href="perfil.php?user=<?= $user ?>"><button class="botao-grande">ir para o perfil</button></a>
            <?php } ?>
                
        </div>
    </main>

    <footer>
        <a href="index.php">
            <img src="img/logo-branco.png" alt="samplaces">
        </a>
        
        <nav>
            <ul>
                <a href="top.php"><li>top</li></a>
                <a href="exibir.php?recente=true"><li>recentes</li></a>

                <a href="https://www.linkedin.com/in/renata-rocha-alves/" target="_blank">
                    <img src="img/linkedin.png" alt="LinkedIn">
                </a>

                <a href="https://github.com/RenataRochaAlves/samplaces" target="_blank">
                    <img src="img/github.png" alt="GitHub">
                </a>
            </ul>
        </nav>
    </footer>
</body>
</html>