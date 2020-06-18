<?php 

include("includes/functions.php");


// criando a persistência de dados
$nome = "";
$user = "";
$bairro = "";
$email = "";
$senha = "";
$confirmacao = "";
$foto = "";

// criando a verificação de dados
$nomeOk = true;
$userOk = true;
$bairroOk = true;
$emailOk = true;
$senhaOk = true;
$confirmacaoOk = true;
$fotoOk = true;

if($_POST){
    // persistência de dados
    $nome = $_POST['nome'];
    $user = $_POST['user'];
    $bairro = $_POST['bairro'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmacao = $_POST['confirmacao'];

    // verificação de dados
    if(strlen($nome) < 8){
        $nomeOk = false;
    }
    if(strlen($user) < 4){
        $userOk = false;
    }

    $verUser = verificaUser($user);

    if(is_array($verUser)){
        $userOk = false;
    }
    if($_POST['naosp'] != null){
        $bairro = $_POST['naosp'];
    }
    if(verificaEmail($email)){
        $emailOk = false;
    }
    if(strpos($email, '@') == false){
        $emailOk = false;
    }
    if(strlen($senha) < 8){
        $senhaOk = false;
    }
    if($confirmacao != $senha){
        $confirmacaoOk = false;
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
        }
        if($error == 4){
            $foto = "img/profile.png";
        }
         
    }
    
    // verifica se os dados inseridos estão certos e insere no banco de dados
    if($nomeOk && $userOk && $bairroOk && $emailOk && $senhaOk && $confirmacaoOk && $fotoOk){
        adicionaUser($nome, $user, $bairro, $email, $senha, $foto);

        $id = carregaUser($user);

        session_start();

            $_SESSION['nome'] = $nome;
            $_SESSION['user'] = $user;
            $_SESSION['foto'] = $foto;
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $id['id'];


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
    <link rel="stylesheet" href="css/form.css">
    <title>Cadastro | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="#"><li>top</li></a>
                <a href="#"><li>recentes</li></a>
                <a href="#"><li id="logout">já possui uma conta? faça login</li></a>
            </ul>
        </nav>
    </header>

    <main>
        <h3>cadastro</h3>

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
                <label for="senha">senha</label><br>
                    <input type="password" name="senha" id="senha" value="<?= $senha ?>" required><br>
                    <?= ($senhaOk? '': '<span class="erro">a senha é muito curta ):') ?><br>
                    <?= ($confirmacaoOk? '': '<span class="erro">a senha e a confirmação são diferentes ):') ?>
                </div>

                <div id="confirmacao">
                <label for="confirmacao">confirmação de senha</label><br>
                    <input type="password" name="confirmacao" id="confirmacao" value="<?= $confirmacao ?>" required><br>
                </div>
            </div>

            <div class="foto-user">
                    <label for="foto">selecione a sua foto de perfil</label><br>
                    <p>de preferência uma foto quadradinha</p>
                    <label class="select-foto">
                        <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif" value="<?= $foto ?>"><br>

                        <img src="img/profile.png" id="foto-carregada"><br>
                    </label>
                    <?= ($fotoOk? '' : '<span class="erro">a imagem é inválida ):')?><br>
                </div>

            <div class="botao">
            <button class="botao-grande" type="submit">Enviar</button>
            </div>
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