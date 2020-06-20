<?php 

include("includes/functions.php");

session_start();

if(isset($_GET['amigos'])){
    $erro = ['nome'=> 'Amigos',
            'head'=> 'poxa ):',
            'text'=>'você ainda não segue ninguém, procure pelo user dos seus amigos na barra de busca!',
            'link'=> 'perfil.php?user='.$_SESSION['user'],
            'botao'=> 'voltar para o perfil'];
}

if(isset($_GET['session'])){
    $erro = ['nome'=> 'Permissão Negada',
            'head'=> 'Oooops!',
            'text'=>'você não pode acessar essa página!',
            'link'=> 'login.php',
            'botao'=> 'faça login para continuar'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title><?= $erro['nome'] ?> | Samplaces</title>
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
                <h3><?= $erro['head'] ?></h3>
                <p><?= $erro['text'] ?></p>
            <a href="<?= $erro['link'] ?>"><button class="botao-grande"><?= $erro['botao'] ?></button></a>
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