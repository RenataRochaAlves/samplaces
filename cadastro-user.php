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

        <form method="POST" class="cad-user">

            <div id="nome">
            <label for="nome">nome completo</label><br>
                <input type="text" name="nome" id="nome" value="<?= $nome ?>" placeholder="Maria da Silva" required><br>
                <!-- <?= ($nomeOk? '': '<span class="erro">O nome é muito curto') ?> -->
            </div>

            <div id="user">
            <label for="user">user</label><br>
                <input type="text" name="user" id="user" value="<?= $nome ?>" placeholder="maria" required><br>
                <!-- <?= ($nomeOk? '': '<span class="erro">O nome é muito curto') ?> -->
            </div>

            <div id="bairro">
            <label for="bairro">bairro</label><br>
                <input type="text" name="bairro" id="bairro" value="<?= $nome ?>" placeholder="República"><br>
                <!-- <?= ($nomeOk? '': '<span class="erro">O nome é muito curto') ?><br> -->
                <input class="checkmark" type="checkbox" name="naosp" id="naosp" value="naosp">
                <label for="naosp">não moro em São Paulo</label>
            </div>

            <div id="email">
            <label for="email">e-mail</label><br>
            <input type="email" name="email" id="email" value="<?= $email ?>" placeholder="maria@email.com" required><br><br>
            <!-- <?= ($emailOk? '': '<span class="erro">O e-mail é inválido') ?> -->
            </div>

            <div id="senhas">
                <div id="senha">
                <label for="senha">senha</label><br>
                    <input type="password" name="senha" id="senha" value="<?= $senha ?>" required><br>
                    <!-- <?= ($senhaOk? '': '<span class="erro">A senha é muito curta') ?><br>
                    <?= ($confirmacaoOk? '': '<span class="erro">A senha e a confirmação são diferentes') ?> -->
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
                        <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif"><br>

                        <img src="img/profile.png" id="foto-carregada"><br>
                    </label>
                    <!-- <?= ($imagemOk? '' : '<span class="erro">A imagem é inválida')?><br> -->
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