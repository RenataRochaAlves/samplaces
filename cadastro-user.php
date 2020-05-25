<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
        <h3>Cadastro</h3>

        <form method="POST" class="cad-user">

            <div id="nome">
            <label for="nomeUsuario">Nome Completo</label><br>
                <input type="text" name="nomeUsuario" id="nomeUsuario" value="<?= $nome ?>" placeholder="Maria da Silva" required>
                <?= ($nomeOk? '': '<span class="erro">O nome é muito curto') ?>
            </div>

            <div id="email">
            <label for="emailUsuario">E-mail</label><br>
            <input type="email" name="emailUsuario" id="emailUsuario" value="<?= $email ?>" placeholder="maria@email.com" required><br>
            <?= ($emailOk? '': '<span class="erro">O e-mail é inválido') ?>
            </div>

            <div id ="senhas">
            <div id="senha">
            <label for="senhaUsuario">Senha</label><br>
                <input type="password" name="senhaUsuario" id="senhaUsuario" value="<?= $senha ?>" required><br>
                <?= ($senhaOk? '': '<span class="erro">A senha é muito curta') ?><br>
                <?= ($confirmacaoOk? '': '<span class="erro">A senha e a confirmação são diferentes') ?>
            </div>

            <div id="confirmacao">
            <label for="confirmacaoUsuario">Confirmação de Senha</label><br>
                <input type="password" name="confirmacaoUsuario" id="confirmacaoUsuario" value="<?= $confirmacao ?>" required><br>
            </div>
            </div>

            <div>
            <button type="submit">Enviar</button>
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
</body>
</html>