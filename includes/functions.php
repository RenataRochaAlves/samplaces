<?php 

include("conexao.php");

// função para adicionar usuários ao banco de dados
function adicionaUser($nome, $user, $bairro, $email, $senha, $foto){

    global $db;

    // procura no bd se o bairro informado já foi cadastrado
    $query = $db->prepare("SELECT * FROM bairros WHERE nome LIKE :bairro");
    $query->execute(["bairro"=>$bairro]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // se já tiver cadastrado, guarda o id para ser usado no cadastro do usuário
    if($result){
        $bairro = $result["id"];
    // se não tiver, cria um novo bairro e guarda o id para ser usado
    } else {
        $query = $db->prepare("INSERT INTO bairros(id, nome) VALUES(DEFAULT, :nome)");
        $query->execute(["nome"=>$bairro]);

        $query = $db->prepare("SELECT * FROM bairros WHERE nome LIKE :bairro");
        $query->execute(["bairro"=>$bairro]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $bairro = $result["id"];
    }

    // adiciona o usuário ao banco de dados 
    $query = $db->prepare("INSERT INTO users(id, user, nome, email, senha, foto, bairros_id) 
    VALUES(DEFAULT, :user, :nome, :email, :senha, :foto, :bairro)");

    $query->execute(["user"=>$user, "nome"=>$nome, "email"=>$email, "senha"=>password_hash($senha, PASSWORD_DEFAULT),
    "foto"=>$foto, "bairro"=>$bairro]);
}

// função que verifica se o user já existe
function verificaUser($user) {
    global $db;

    // procura no banco de dados o user que a pessoa quer inserir
    $query = $db->prepare("SELECT * FROM users WHERE user LIKE :user");
    $query->execute(["user"=>$user]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // compara se o resultado encontrado é igual o que a pessoa quer inserir
    return is_array($result);
}

// função que verifica se o e-mail já foi cadastrado
function verificaEmail($email) {
    global $db;

    // procura no banco de dados o user que a pessoa quer inserir
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->execute(["email"=>$email]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // compara se o resultado encontrado é igual o que a pessoa quer inserir
    return is_array($result);
}

?>