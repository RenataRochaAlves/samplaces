<?php 

include("includes/functions.php");

if($_GET['user']){
    $user = $_GET['user'];

    $perfil = carregaUser($user);

    // criando a persistência de dados
    $id = $perfil['id'];
    $nome = $perfil['nome'];
    $user = $perfil['user'];
    $bairro = $perfil['bairro'];
    $email = $perfil['email'];
    $senha = "";
    $confirmacao = "";
    $senhaAnt = "";
    $foto = $perfil['foto'];
}

// criando a verificação de dados
$nomeOk = true;
$userOk = true;
$bairroOk = true;
$emailOk = true;
$senhaOk = true;
$confirmacaoOk = true;
$senhaAntOk = true;
$fotoOk = true;

if($_POST){
    // persistência de dados
    $nome = $_POST['nome'];
    $user = $_POST['user'];
    $bairro = $_POST['bairro'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senhaAnt = $_POST['senhaAnt'];
    $confirmacao = $_POST['confirmacao'];

    // verificação de dados
    if(strlen($nome) < 8){
        $nomeOk = false;
    }
    if($user != $perfil['user']){
        if(strlen($user) < 4){
            $userOk = false;
        }
        if(verificaUser($user)){
            $userOk = false;
        }
    }
    if(isset($_POST['naosp'])){
        $bairro = $_POST['naosp'];
    }
    if($email != $perfil['email']){
        if(verificaEmail($email)){
            $emailOk = false;
        }
        if(strpos($email, '@') == false){
            $emailOk = false;
        }
    }
    if($_POST['senha'] != ''){
        if(strlen($senha) < 8){
            $senhaOk = false;
        }
        if($confirmacao != $senha){
            $confirmacaoOk = false;
        }
    }
    if(password_verify($senhaAnt, $perfil['senha']) == false){
        $senhaAntOk = false;
    }
    // verifica se enviaram uma imagem
    if($_FILES) {
        // Separando informações uteis do $_FILES
        $tmpName = $_FILES['foto']['tmp_name'];
        $fileName = $user . '-' . $_FILES['foto']['name'];
        $error = $_FILES['foto']['error'];
        
        // Salvar o arquivo numa pasta do meu sistema
        if($error == 0){
            move_uploaded_file($tmpName,'img/users/'.$fileName);

        // Salvar o nome do arquivo em $foto
        $foto ='img/users/'.$fileName;
        } else {
            $foto = $perfil['foto'];
        }
    }

    // verifica se os dados inseridos estão certos e insere no banco de dados
    if($nomeOk && $userOk && $bairroOk && $emailOk && $senhaOk && $confirmacaoOk && $fotoOk && $senhaAntOk){
        if($_POST['senha'] != ''){
            editaUser($id, $nome, $user, $bairro, $email, password_hash($senha, PASSWORD_DEFAULT), $foto);
        } else {
            editaUser($id, $nome, $user, $bairro, $email, $perfil['senha'], $foto);
        }

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <title>Editar Usuário | Samplaces</title>
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
        <h3>editar usuário</h3>

        <form method="POST" class="cad-user" enctype="multipart/form-data">

            <div id="nome">
            <label for="nome">nome completo</label><br>
                <input type="text" name="nome" id="nome" value="<?= $nome ?>" placeholder="Maria da Silva" required><br>
                <?= ($nomeOk? '': '<span class="erro">o nome é muito curto ):') ?>
            </div>

            <div id="user">
            <label for="user">user</label><br>
                <input type="text" name="user" id="user" value="<?= $user ?>" placeholder="maria" required><br>
                <?= ($userOk? '': '<span class="erro">user inválido ):') ?>
            </div>

            <div id="bairro">
            <label for="bairro">bairro</label><br>
                <input type="text" name="bairro" id="bairro" value="<?= $bairro ?>" placeholder="República"><br>
                <input class="checkmark" type="checkbox" name="naosp" id="naosp" value="não mora em São Paulo">
                <label for="naosp">não moro em São Paulo</label>
            </div>

            <div id="email">
            <label for="email">e-mail</label><br>
            <input type="email" name="email" id="email" value="<?= $email ?>" placeholder="maria@email.com" required><br><br>
            <?= ($emailOk? '': '<span class="erro">o e-mail é inválido ):') ?>
            </div>

            <div id="senhas">
                <div id="senha">
                <label for="senha">nova senha</label><br>
                    <input type="password" name="senha" id="senha" value="<?= $senha ?>"><br>
                    <?= ($senhaOk? '': '<span class="erro">a senha é muito curta ):') ?>
                    
                </div>

                <div id="confirmacao">
                <label for="confirmacao">confirmação da nova senha</label><br>
                    <input type="password" name="confirmacao" id="confirmacao" value="<?= $confirmacao ?>"><br>
                    <?= ($confirmacaoOk? '': '<span class="erro">a senha e a confirmação são diferentes ):') ?>
                </div>

                <div id="senhaAnt">
                <label for="senhaAnt">senha atual</label><br>
                    <input type="password" name="senhaAnt" id="senhaAnt" value="<?= $senhaAnt ?>" required><br>
                    <?= ($senhaAntOk? '': '<span class="erro">a senha antiga está incorreta ):') ?>
                </div>
            </div>

            <div class="foto-edit">
                    <label for="foto">selecione a sua foto de perfil</label><br>
                    <p>de preferência uma foto quadradinha</p>
                    <label class="select-foto">
                        <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif" value="<?= $foto ?>"><br>

                        <img src="<?= $foto ?>" id="foto-carregada"><br>
                    </label>
                    <?= ($fotoOk? '' : '<span class="erro">a imagem é inválida ):')?><br>
                </div>

            
            <button class="botao-edit" id="excluir"><a href="#">Excluir minha conta</a></button>
            <button class="botao-edit" type="submit">Enviar</button>
            
        </form>
        
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