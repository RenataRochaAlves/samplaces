<?php 

include("includes/functions.php");


// criando a persistência de dados
$user = "";
$senha = "";

// criando a verificação de dados
$userOk = true;
$senhaOk = true;

if($_POST){
    // persistência de dados
    $user = $_POST['user'];
    $senha = $_POST['senha'];

    $perfil = carregaUser($user);

    // verificação de dados
    if(is_array($perfil)){
        if(password_verify($senha, $perfil['senha'])){

            session_start();

            $_SESSION['nome'] = $perfil['nome'];
            $_SESSION['user'] = $perfil['user'];
            $_SESSION['foto'] = $perfil['foto'];
            $_SESSION['email'] = $perfil['email'];
            $_SESSION['id'] = $perfil['id'];

            header('location: perfil.php?user='.$user);
        } else{
            $senhaOk = false;
        }
    } else{
        $userOk = false;
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
    <title>Login | Samplaces</title>
</head>
<body>

    <header>
        <img id="logo" src="img/logo-site.png" alt="samplaces">
        <nav>
            <ul>
                <a href="top.php"><li>top</li></a>
                <a href="exibir.php?recente=true"><li>recentes</li></a>
                <a href="cadastro-user.php"><li id="logout">não possui uma conta? cadastre-se</li></a>
            </ul>
        </nav>
    </header>

    <main>
        <h3>login</h3>

        <form method="POST" class="login">

            <div id="user">
            <label for="user">user</label><br>
                <input type="text" name="user" id="user" value="<?= $user ?>" placeholder="maria" required><br>
                <?= ($userOk? '': '<span class="erro">user não cadastrado ):') ?>
            </div>

            <div id="senha">
                <label for="senha">senha</label><br>
                    <input type="password" name="senha" id="senha" value="<?= $senha ?>" required><br>
                    <?= ($senhaOk? '': '<span class="erro">senha incorreta ):') ?><br>
            </div>

            <a href="cadastro-user.php" class="nova-conta"><p>não possui uma conta? cadastre-se</p></a>

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