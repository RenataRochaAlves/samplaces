<?php 

include("includes/functions.php");

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

$lugar = $favcad['lugar'];
$texto = $favcad['descricao'];
$foto = $favcad['foto'];

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

        } 
    }
    
    if($lugarOk && $textoOk && $fotoOk){

        editaFavorito($lugar, $texto, $foto, $user, $perfil['id'], $favorito['id']);

        header('location: perfil.php?user='.$user);
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

            <h3 style="color: <?= $favorito['cor'] ?>"><?= $favorito['nome'] ?></h3>
            <article class="favorito">

                <form class="form-fav" method="post" enctype="multipart/form-data">
                
                <div class="imagem-grande">
                    <?= ($fotoOk? '' : '<span class="erro">a imagem é inválida ):')?>
                    <label class="select-foto">
                            <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif" value="<?= $foto ?>">

                            <img src="<?= $foto ?>" id="foto-carregada">
                        </label><br>
                        
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
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=favorito"><li>lugar favorito ever</li></a>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=amigos"><li>favorito para encontrar os amigos</li></a>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=date"><li>favorito para um date</li></a>
                    <a href="favorito.php?user=<?= $perfil['user'] ?>&fav=domingo"><li>favorito de domingo</li></a>
                </ul>
            </nav>

            <nav class="menu-user">
                <ul>
                    <a href="#"><li>salvos</li></a>
                    <a href="editar-user.php?user=<?= $perfil['user'] ?>"><li>configurações</li></a>
                    <a href="#"><li>sair</li></a>
                </ul>
            </nav>
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