<?php 

include("includes/functions.php");

session_start();

if(isset($_SESSION['user']) == false || isset($_SESSION['user']) && $_SESSION['user'] != $_GET['user']){
    header('location: erro.php?session=true');
}

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

$lugar = "";
$texto = "";
$foto = "";

$lugarOk = true;
$textoOk = true;
$fotoOk = true;

if($_POST){

    $lugar = $_POST['lugar'];
    $texto = $_POST['texto'];

    if(strlen($lugar) < 5){
        $lugarOk = false;
    }
    if(strlen($texto) > 256){
        $textoOk = false;
    }
    if($_FILES) {
        // Separando informações uteis do $_FILES
        $tmpName = $_FILES['foto']['tmp_name'];
        $fileName = $user . '-' . $favorito['curto'] . '-' . $_FILES['foto']['name'];
        $error = $_FILES['foto']['error'];

        // Salvar o arquivo numa pasta do meu sistema
        if($error == 0){
            move_uploaded_file($tmpName,'img/favoritos/'.$fileName);

        // Salvar o nome do arquivo em $foto
        $foto ='img/favoritos/'.$fileName;

        } else {
            $fotoOk = false; 
        }
    } else {
        $fotoOk = false;
    }

    if($lugarOk && $textoOk && $fotoOk){

        adicionaFavorito($lugar, $texto, $foto, $perfil['id'], $favorito['id']);

        header('location: perfil.php?user='.$user);
    }
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
    <title>adicionar <?= $favorito['nome'] ?> | Samplaces</title>
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
        <div class="conteudo perfil">

            <h3 style="color: <?= $favorito['cor'] ?>"><?= $favorito['nome'] ?></h3>
            <article class="favorito">

                <form class="form-fav" method="post" enctype="multipart/form-data">
                
                <div class="imagem-grande">
                    <label class="select-foto">
                            <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif" required>

                            <img src="img/nova-imagem2.png" id="foto-carregada">
                        </label><br>
                        <?= ($fotoOk? '' : '<span class="erro">a imagem é inválida ):')?>
                </div>
                <div class="info">
                    <input type="text" name="lugar" id="lugar" value="<?= $lugar ?>" 
                    placeholder="nome do lugar (ex: Edifício Martinelli)" style="color: <?= $favorito['cor'] ?>" required><br>
                    <?= ($lugarOk? '' : '<span class="erro">o texto é muito curto ):')?><br>

                    <textarea name="texto" id="texto" cols="30" rows="10" maxlenght="256" value="<?= $texto ?>"
                    placeholder="conta pra gente alguma história ou o motivo de gostar desse lugar em 256 caracteres"><?= $texto ?></textarea><br>
                    <?= ($textoOk? '' : '<span class="erro">oops! texto muito grande ):')?><br>
                    
                    <button type="submit" class="botao-grande">enviar</button>
                </div>
                </form>
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
                            <li>lugar favorito ever</li>
                            <li class="user-icon"><img src="img/favorito.png" alt="favorito"></li>
                        </a>

                    <?php if(carregaFavUserTipo($user, 2) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=amigos">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=amigos">
                    <?php } ?>
                            <li>favorito para encontrar os amigos</li>
                            <li class="user-icon"><img src="img/amigos.png" alt="amigos"></li>
                        </a>

                    <?php if(carregaFavUserTipo($user, 3) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=date">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=date">
                    <?php } ?>
                            <li>favorito para um date</li>
                            <li class="user-icon"><img src="img/date.png" alt="date"></li>
                        </a>

                    <?php if(carregaFavUserTipo($user, 4) == false && isset($_SESSION['user']) && $_SESSION['user'] == $user){ ?>
                        <a href="cadastro-fav.php?user=<?= $user ?>&fav=domingo">
                    <?php } else { ?>
                        <a href="favorito.php?user=<?= $user ?>&fav=domingo">
                    <?php } ?>
                            <li>favorito de domingo</li>
                            <li class="user-icon"><img src="img/domingo.png" alt="domingo"></li>
                        </a>
                </ul>
            </nav>

            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == $perfil['user']){ ?>
                <nav class="menu-user">
                    <ul>
                        <a href="editar-user.php?user=<?= $perfil['user'] ?>"><li>configurações</li></a>
                        <a href="logout.php"><li>sair</li></a>
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